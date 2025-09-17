<?php
header('Content-Type: application/json');
require_once '../config/conexion.php';

try {
    $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($productId <= 0) {
        throw new Exception("ID de producto inválido");
    }

    $sql = "SELECT p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, 
                   p.cantidad, p.peso, p.estado, p.sku, p.vistas, c.categoria,
                   AVG(r.calificacion) as promedio_calificacion, COUNT(r.ID) as total_resenas
            FROM producto p 
            LEFT JOIN categoria c ON p.categoria_ID = c.ID 
            LEFT JOIN resena r ON p.resena_ID = r.ID 
            WHERE p.ID = ? AND p.estado = 'Disponible'
            GROUP BY p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, 
                     p.cantidad, p.peso, p.estado, p.sku, p.vistas, c.categoria";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Producto no encontrado");
    }

    $product = $result->fetch_assoc();
    $product['precio_final'] = $product['descuento'] ? 
        $product['precio_unitario'] * (1 - $product['descuento'] / 100) : 
        $product['precio_unitario'];
    $product['promedio_calificacion'] = $product['promedio_calificacion'] ? 
        round($product['promedio_calificacion'], 1) : 0;

    echo json_encode([
        'success' => true,
        'data' => $product
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
