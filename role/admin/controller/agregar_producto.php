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
    $nombre = trim($_POST['nombre']);
    $marca = trim($_POST['marca']);
    $cantidad = intval($_POST['cantidad']);
    $descripcion = trim($_POST['descripcion']);
    $sku = trim($_POST['sku']);
    $precio_unitario = floatval($_POST['precio_unitario']);
    $peso = floatval($_POST['peso']);
    $estado = trim($_POST['estado']);
    $categoria_ID = intval($_POST['categoria_ID']);
    $proveedor_ID = intval($_POST['proveedor_ID']);
    
    // Validaciones básicas
    if (empty($nombre) || empty($marca) || $cantidad < 0 || $precio_unitario < 0 || $categoria_ID <= 0 || $proveedor_ID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados correctamente']);
        exit();
    }
    
    // Procesar imagen si se subió
    $foto_nombre = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validar tipo de archivo
        if (!in_array($foto['type'], $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido. Use JPG, PNG o GIF']);
            exit();
        }
        
        // Validar tamaño
        if ($foto['size'] > $max_size) {
            echo json_encode(['success' => false, 'message' => 'El archivo es demasiado grande. Máximo 5MB']);
            exit();
        }
        
        // Generar nombre único para la imagen
        $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $foto_nombre = 'producto_' . time() . '_' . uniqid() . '.' . $extension;
        $ruta_destino = '../public/img/' . $foto_nombre;
        
        // Mover archivo
        if (!move_uploaded_file($foto['tmp_name'], $ruta_destino)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
            exit();
        }
    }
    
    // Insertar producto en la base de datos
    $insert_query = "INSERT INTO producto (nombre, marca, cantidad, descripcion, sku, precio_unitario, peso, estado, foto, categoria_ID, proveedor_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "ssisdsssiii", $nombre, $marca, $cantidad, $descripcion, $sku, $precio_unitario, $peso, $estado, $foto_nombre, $categoria_ID, $proveedor_ID);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        $producto_id = mysqli_insert_id($conn);
        header("Location: ../view/home/ad_home.php");;
    } else {
        // Si hay error, eliminar la imagen subida
        if ($foto_nombre && file_exists($ruta_destino)) {
            unlink($ruta_destino);
        }
        echo json_encode(['success' => false, 'message' => 'Error al agregar el producto: ' . mysqli_error($conn)]);
    }
    
    mysqli_stmt_close($insert_stmt);
} else {
    header("Location: ../view/home/ad_home.php");;
}

mysqli_close($conn);
?>
