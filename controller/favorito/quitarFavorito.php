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

    // Obtener favorito del usuario
    $getFav = $conn->prepare("SELECT ID FROM favorito WHERE usuario_ID = ?");
    $getFav->bind_param("i", $userId);
    $getFav->execute();
    $favResult = $getFav->get_result();

    if ($favResult->num_rows === 0) {
        throw new Exception("Favorito no encontrado");
    }

    $fav = $favResult->fetch_assoc();
    $favId = $fav['ID'];

    // Eliminar producto de favoritos
    $deleteFavItem = $conn->prepare("DELETE FROM favorito_producto WHERE favorito_ID = ? AND producto_ID = ?");
    $deleteFavItem->bind_param("ii", $favId, $productId);
    $deleteFavItem->execute();

    if ($deleteFavItem->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto eliminado de favoritos exitosamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado en favoritos'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
