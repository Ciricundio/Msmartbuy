<?php
session_start();
include_once '../../../config/conexion.php';
header('Content-Type: application/json');

// Verificar autenticación y rol
if (!isset($_SESSION['ID']) && !isset($_SESSION['rol'])!== 'admin') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar datos
    $categoria = trim($_POST['categoria']);
    
    if (empty($categoria)) {
        echo json_encode(['success' => false, 'message' => 'El nombre de la categoría es requerido']);
        exit();
    }
    
    // Verificar si la categoría ya existe
    $check_query = "SELECT ID FROM categoria WHERE categoria = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $categoria);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'La categoria ya existe']);
        exit();
    }
    
    // Insertar nueva categoría
    $insert_query = "INSERT INTO categoria (categoria) VALUES (?)";
    $insert_stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "s", $categoria);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        $categoria_id = mysqli_insert_id($conn);
        header("Location: ../view/home/ad_home.php");
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la categoría: ' . mysqli_error($conn)]);
    }
    
    mysqli_stmt_close($insert_stmt);
    mysqli_stmt_close($check_stmt);
} else {
    header("Location: ../view/home/ad_home.php");
}

mysqli_close($conn);
?>
