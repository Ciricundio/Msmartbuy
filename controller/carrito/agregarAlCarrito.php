<?php
// Configurar headers para CORS y JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

// Iniciar sesión antes de incluir la conexión
session_start();

require_once '../../config/conexion.php';

try {
    // Verificar que la sesión esté activa
    if (!isset($_SESSION['ID']) || empty($_SESSION['ID'])) {
        throw new Exception("Sesión no válida. Por favor, inicia sesión nuevamente.");
    }
    
    $userId = $_SESSION['ID'];
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    if ($productId <= 0 || $quantity <= 0) {
        throw new Exception("Datos inválidos");
    }

    // Verificar si el producto existe y está activo
    $checkProduct = $conn->prepare("SELECT ID FROM producto WHERE ID = ? AND estado = 'Disponible'");
    $checkProduct->bind_param("i", $productId);
    $checkProduct->execute();
    if ($checkProduct->get_result()->num_rows === 0) {
        throw new Exception("Producto no encontrado");
    }

    // Obtener o crear carrito del usuario
    $getCart = $conn->prepare("SELECT ID FROM carrito WHERE usuario_ID = ?");
    $getCart->bind_param("i", $userId);
    $getCart->execute();
    $cartResult = $getCart->get_result();

    if ($cartResult->num_rows === 0) {
        // Crear nuevo carrito
        $createCart = $conn->prepare("INSERT INTO carrito (fecha_creacion, usuario_ID) VALUES (CURDATE(), ?)");
        $createCart->bind_param("i", $userId);
        $createCart->execute();
        $cartId = $conn->insert_id;
    } else {
        $cart = $cartResult->fetch_assoc();
        $cartId = $cart['ID'];
    }

    // Verificar si el producto ya está en el carrito
    $checkItem = $conn->prepare("SELECT cantidad FROM carrito_producto WHERE carrito_ID = ? AND producto_ID = ?");
    $checkItem->bind_param("ii", $cartId, $productId);
    $checkItem->execute();
    $itemResult = $checkItem->get_result();

    if ($itemResult->num_rows > 0) {
        // Actualizar cantidad existente
        $existingItem = $itemResult->fetch_assoc();
        $newQuantity = $existingItem['cantidad'] + $quantity;
        
        $updateItem = $conn->prepare("UPDATE carrito_producto SET cantidad = ?, subtotal = (SELECT precio_unitario * ? FROM producto WHERE ID = ?) WHERE carrito_ID = ? AND producto_ID = ?");
        $updateItem->bind_param("iiiii", $newQuantity, $newQuantity, $productId, $cartId, $productId);
        $updateItem->execute();
    } else {
        // Agregar nuevo producto al carrito
        $insertItem = $conn->prepare("INSERT INTO carrito_producto (carrito_ID, producto_ID, cantidad, subtotal) 
                                     SELECT ?, ?, ?, precio_unitario * ? FROM producto WHERE ID = ?");
        $insertItem->bind_param("iiiii", $cartId, $productId, $quantity, $quantity, $productId);
        $insertItem->execute();
    }

    echo json_encode([
        'success' => true,
        'message' => 'Producto agregado al carrito exitosamente'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
