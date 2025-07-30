<?php
session_start();
include_once '../../../config/conexion.php';
header('Content-Type: application/json');

// Verificar autenticación y rol
if (!isset($_SESSION['ID']) || $_SESSION['rol'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

try {
    $query = "SELECT ID, categoria, imagen FROM categoria ORDER BY categoria ASC";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($conn));
    }
    
    $categorias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categorias[] = [
            'ID' => $row['ID'],
            'categoria' => $row['categoria'],
            'imagen' => $row['imagen'] ?? 'default'
        ];
    }
    
    echo json_encode([
        'success' => true,
        'categorias' => $categorias
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener categorías: ' . $e->getMessage()
    ]);
}

mysqli_close($conn);
?>
