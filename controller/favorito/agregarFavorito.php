<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';

try {
    session_start();
    $userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_POST['user_id']) ? intval($_POST['user_id']) : 0);
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    if ($productId <= 0) {
        throw new Exception("ID de producto inválido");
    }

    // Verificar si el producto existe y está disponible
    $checkProduct = $conn->prepare("SELECT ID FROM producto WHERE ID = ? AND estado = 'Disponible'");
    $checkProduct->bind_param("i", $productId);
    $checkProduct->execute();
    if ($checkProduct->get_result()->num_rows === 0) {
        throw new Exception("Producto no encontrado");
    }

    // Obtener o crear favorito del usuario
    $getFav = $conn->prepare("SELECT ID FROM favorito WHERE usuario_ID = ?");
    $getFav->bind_param("i", $userId);
    $getFav->execute();
    $favResult = $getFav->get_result();

    if ($favResult->num_rows === 0) {
        // Crear nuevo favorito
        $createFav = $conn->prepare("INSERT INTO favorito (usuario_ID) VALUES (?)");
        $createFav->bind_param("i", $userId);
        $createFav->execute();
        $favId = $conn->insert_id;
    } else {
        $fav = $favResult->fetch_assoc();
        $favId = $fav['ID'];
    }

    // Verificar si el producto ya está en favoritos
    $checkFavItem = $conn->prepare("SELECT * FROM favorito_producto WHERE favorito_ID = ? AND producto_ID = ?");
    $checkFavItem->bind_param("ii", $favId, $productId);
    $checkFavItem->execute();
    $favItemResult = $checkFavItem->get_result();

    if ($favItemResult->num_rows > 0) {
        throw new Exception("Producto ya está en favoritos");
    }

    // Agregar producto a favoritos
    $insertFavItem = $conn->prepare("INSERT INTO favorito_producto (favorito_ID, producto_ID) VALUES (?, ?)");
    $insertFavItem->bind_param("ii", $favId, $productId);
    $insertFavItem->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Producto agregado a favoritos exitosamente'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
