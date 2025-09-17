<?php
session_start();
require_once '../../config/conexion.php';

header('Content-Type: application/json');

$userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_GET['user_id']) ? intval($_GET['user_id']) : 0);

$response = [
    'success' => false,
    'data' => [],
    'error' => null
];

if ($userId <= 0) {
    $response['error'] = "Usuario no autenticado";
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $sql = "SELECT p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, c.categoria
            FROM favorito_producto fp
            JOIN favorito f ON fp.favorito_ID = f.ID
            JOIN producto p ON fp.producto_ID = p.ID
            JOIN categoria c ON p.categoria_ID = c.ID
            WHERE f.usuario_ID = ? AND p.estado = 'Disponible'
            ORDER BY p.nombre";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorites = [];
    while ($row = $result->fetch_assoc()) {
        $row['precio_final'] = $row['descuento']
            ? $row['precio_unitario'] * (1 - $row['descuento'] / 100)
            : $row['precio_unitario'];
        $favorites[] = $row;
    }

    $response['success'] = true;
    $response['data'] = $favorites;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>