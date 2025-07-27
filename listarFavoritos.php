<?php
header('Content-Type: application/json');
require_once 'config/conexion.php';

try {
    session_start();
    $userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_GET['user_id']) ? intval($_GET['user_id']) : 0);

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    $sql = "SELECT p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, c.categoria
            FROM favorito_producto fp
            JOIN favorito f ON fp.favorito_ID = f.ID
            JOIN producto p ON fp.producto_ID = p.ID
            JOIN categoria c ON p.categoria_ID = c.ID
            WHERE f.usuario_ID = ? AND p.estado = 'Disponible'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorites = [];
    while ($row = $result->fetch_assoc()) {
        $row['precio_final'] = $row['descuento'] ? 
            $row['precio_unitario'] * (1 - $row['descuento'] / 100) : 
            $row['precio_unitario'];
        $favorites[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $favorites,
        'total' => count($favorites)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
