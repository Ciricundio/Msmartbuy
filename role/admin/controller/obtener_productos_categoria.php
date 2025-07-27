<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

include_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['categoria_id'])) {
    $categoria_id = intval($_GET['categoria_id']);
    
    if ($categoria_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID de categoría inválido']);
        exit();
    }
    
    // Obtener información de la categoría
    $categoria_query = "SELECT categoria FROM categoria WHERE categoria_ID = ?";
    $categoria_stmt = mysqli_prepare($conexion, $categoria_query);
    mysqli_stmt_bind_param($categoria_stmt, "i", $categoria_id);
    mysqli_stmt_execute($categoria_stmt);
    $categoria_result = mysqli_stmt_get_result($categoria_stmt);
    $categoria_info = mysqli_fetch_assoc($categoria_result);
    
    if (!$categoria_info) {
        echo json_encode(['success' => false, 'message' => 'Categoría no encontrada']);
        exit();
    }
    
    // Obtener productos de la categoría
    $productos_query = "SELECT p.producto_ID, p.nombre, p.marca, p.cantidad, p.precio_unitario, p.foto, p.estado, u.nombre as proveedor_nombre 
                       FROM producto p 
                       LEFT JOIN usuario u ON p.proveedor_ID = u.usuario_ID 
                       WHERE p.categoria_ID = ? 
                       ORDER BY p.nombre ASC";
    $productos_stmt = mysqli_prepare($conexion, $productos_query);
    mysqli_stmt_bind_param($productos_stmt, "i", $categoria_id);
    mysqli_stmt_execute($productos_stmt);
    $productos_result = mysqli_stmt_get_result($productos_stmt);
    
    $productos = [];
    while ($producto = mysqli_fetch_assoc($productos_result)) {
        $productos[] = [
            'producto_ID' => $producto['producto_ID'],
            'nombre' => $producto['nombre'],
            'marca' => $producto['marca'],
            'cantidad' => $producto['cantidad'],
            'precio_unitario' => number_format($producto['precio_unitario'], 2),
            'foto' => $producto['foto'] ? '../../public/img/' . $producto['foto'] : '../../public/img/default-product.jpg',
            'estado' => $producto['estado'],
            'proveedor_nombre' => $producto['proveedor_nombre']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'categoria' => $categoria_info['categoria'],
        'productos' => $productos
    ]);
    
    mysqli_stmt_close($categoria_stmt);
    mysqli_stmt_close($productos_stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos']);
}

mysqli_close($conexion);
?>
