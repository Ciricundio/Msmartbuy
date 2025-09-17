<?php
header('Content-Type: application/json');
require_once '../config/conexion.php';

try {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    
    if (empty($search) || strlen($search) < 2) {
        echo json_encode([
            'success' => true,
            'data' => [],
            'message' => 'Búsqueda muy corta'
        ]);
        exit;
    }

    $sql = "SELECT p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, p.sku, p.cantidad, p.peso, p.estado
            FROM producto p 
            WHERE p.estado = 'Disponible' 
            AND (p.nombre LIKE ? OR p.descripcion LIKE ? OR p.marca LIKE ?)
            ORDER BY p.nombre ASC 
            LIMIT 10";

    $searchTerm = "%$search%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['precio_final'] = $row['descuento'] ? 
            $row['precio_unitario'] * (1 - $row['descuento'] / 100) : 
            $row['precio_unitario'];
        $products[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $products,
        'total' => count($products)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al buscar productos: ' . $e->getMessage()
    ]);
}
?>
