<?php
// Configurar headers para CORS y JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

// Iniciar sesión antes de incluir la conexión
session_start();

require_once 'config/conexion.php';

try {
    // Verificar que la sesión esté activa
    if (!isset($_SESSION['ID']) || empty($_SESSION['ID'])) {
        throw new Exception("Sesión no válida. Por favor, inicia sesión nuevamente.");
    }
    
    $userId = $_SESSION['ID'];
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    if ($productId <= 0) {
        throw new Exception("ID de producto inválido");
    }

    // Obtener carrito del usuario
    $getCart = $conn->prepare("SELECT ID FROM carrito WHERE usuario_ID = ?");
    $getCart->bind_param("i", $userId);
    $getCart->execute();
    $cartResult = $getCart->get_result();

    if ($cartResult->num_rows === 0) {
        throw new Exception("Carrito no encontrado");
    }

    $cart = $cartResult->fetch_assoc();
    $cartId = $cart['ID'];

    // Eliminar producto del carrito
    $deleteItem = $conn->prepare("DELETE FROM carrito_producto WHERE carrito_ID = ? AND producto_ID = ?");
    $deleteItem->bind_param("ii", $cartId, $productId);
    $deleteItem->execute();

    if ($deleteItem->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto eliminado del carrito exitosamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado en el carrito'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
