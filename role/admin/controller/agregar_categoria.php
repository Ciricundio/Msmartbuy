<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

include_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar datos
    $categoria = trim($_POST['categoria']);
    
    if (empty($categoria)) {
        echo json_encode(['success' => false, 'message' => 'El nombre de la categoría es requerido']);
        exit();
    }
    
    // Verificar si la categoría ya existe
    $check_query = "SELECT categoria_ID FROM categoria WHERE categoria = ?";
    $check_stmt = mysqli_prepare($conexion, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $categoria);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'La categoría ya existe']);
        exit();
    }
    
    // Insertar nueva categoría
    $insert_query = "INSERT INTO categoria (categoria) VALUES (?)";
    $insert_stmt = mysqli_prepare($conexion, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "s", $categoria);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        $categoria_id = mysqli_insert_id($conexion);
        echo json_encode([
            'success' => true, 
            'message' => 'Categoría agregada exitosamente',
            'categoria_id' => $categoria_id,
            'categoria_nombre' => $categoria
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la categoría: ' . mysqli_error($conexion)]);
    }
    
    mysqli_stmt_close($insert_stmt);
    mysqli_stmt_close($check_stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

mysqli_close($conexion);
?>
