<?php
session_start();
include_once '../../../config/conexion.php';
header('Content-Type: application/json');

// Verificar autenticación y rol
if (!isset($_SESSION['ID']) || $_SESSION['rol'] == 'admin') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar datos
    $producto_id = intval($_POST['producto_id']);
    $nombre = trim($_POST['nombre']);
    $marca = trim($_POST['marca']);
    $cantidad = intval($_POST['cantidad']);
    $descripcion = trim($_POST['descripcion']);
    $sku = trim($_POST['sku']);
    $precio_unitario = floatval($_POST['precio_unitario']);
    $descuento = isset($_POST['descuento']) ? floatval($_POST['descuento']) : 0;
    $peso = trim($_POST['peso']);
    $estado = trim($_POST['estado']);
    $categoria_ID = intval($_POST['categoria_ID']);
    $proveedor_ID = intval($_POST['proveedor_ID']);
    
    // Validaciones básicas
    if ($producto_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
        exit();
    }
    
    if (empty($nombre) || empty($marca) || $cantidad < 0 || $precio_unitario < 0 || 
        $descuento < 0 || $descuento > 100 || $categoria_ID <= 0 || $proveedor_ID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados correctamente']);
        exit();
    }
    
    if (empty($sku)) {
        echo json_encode(['success' => false, 'message' => 'El SKU es obligatorio']);
        exit();
    }
    
    if (!in_array($estado, ['Disponible', 'Agotado', 'Descontinuado'])) {
        echo json_encode(['success' => false, 'message' => 'Estado inválido']);
        exit();
    }
    
    // Verificar que el producto existe
    $check_query = "SELECT ID FROM producto WHERE ID = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $producto_id);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($result) === 0) {
        mysqli_stmt_close($check_stmt);
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit();
    }
    mysqli_stmt_close($check_stmt);
    
    // Verificar que el SKU no esté duplicado (excepto para el producto actual)
    $sku_check_query = "SELECT ID FROM producto WHERE sku = ? AND ID != ?";
    $sku_stmt = mysqli_prepare($conn, $sku_check_query);
    mysqli_stmt_bind_param($sku_stmt, "si", $sku, $producto_id);
    mysqli_stmt_execute($sku_stmt);
    $sku_result = mysqli_stmt_get_result($sku_stmt);
    
    if (mysqli_num_rows($sku_result) > 0) {
        mysqli_stmt_close($sku_stmt);
        echo json_encode(['success' => false, 'message' => 'El SKU ya existe para otro producto']);
        exit();
    }
    mysqli_stmt_close($sku_stmt);
    
    // Verificar que la categoría existe
    $cat_check_query = "SELECT ID FROM categoria WHERE ID = ?";
    $cat_stmt = mysqli_prepare($conn, $cat_check_query);
    mysqli_stmt_bind_param($cat_stmt, "i", $categoria_ID);
    mysqli_stmt_execute($cat_stmt);
    $cat_result = mysqli_stmt_get_result($cat_stmt);
    
    if (mysqli_num_rows($cat_result) === 0) {
        mysqli_stmt_close($cat_stmt);
        echo json_encode(['success' => false, 'message' => 'Categoría no válida']);
        exit();
    }
    mysqli_stmt_close($cat_stmt);
    
    // Verificar que el proveedor existe
    $prov_check_query = "SELECT ID FROM proveedor WHERE ID = ?";
    $prov_stmt = mysqli_prepare($conn, $prov_check_query);
    mysqli_stmt_bind_param($prov_stmt, "i", $proveedor_ID);
    mysqli_stmt_execute($prov_stmt);
    $prov_result = mysqli_stmt_get_result($prov_stmt);
    
    if (mysqli_num_rows($prov_result) === 0) {
        mysqli_stmt_close($prov_stmt);
        echo json_encode(['success' => false, 'message' => 'Proveedor no válido']);
        exit();
    }
    mysqli_stmt_close($prov_stmt);
    
    // Actualizar producto en la base de datos usando el parámetro SQL_SAFE_UPDATES
    $update_query = "UPDATE producto SET 
                     nombre = ?, marca = ?, cantidad = ?, descripcion = ?, 
                     sku = ?, precio_unitario = ?, descuento = ?, peso = ?, 
                     estado = ?, categoria_ID = ?, proveedor_ID = ? 
                     WHERE ID = ?";
    
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ssissddsssii", 
                          $nombre, $marca, $cantidad, $descripcion, $sku, 
                          $precio_unitario, $descuento, $peso, $estado, 
                          $categoria_ID, $proveedor_ID, $producto_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        if (mysqli_stmt_affected_rows($update_stmt) > 0) {
            echo json_encode([
                'success' => true, 
                'message' => 'Producto actualizado correctamente',
                'producto_id' => $producto_id
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'No se realizaron cambios en el producto'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al actualizar el producto: ' . mysqli_error($conn)
        ]);
    }
    
    mysqli_stmt_close($update_stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

mysqli_close($conn);
?>