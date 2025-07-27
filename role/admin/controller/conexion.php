<?php
// Configuración de la base de datos
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$base_datos = "msmartbuy";

// Crear conexión
$conexion = mysqli_connect($servidor, $usuario_db, $password_db, $base_datos);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar charset para evitar problemas con caracteres especiales
mysqli_set_charset($conexion, "utf8");

// Configurar zona horaria
date_default_timezone_set('America/Bogota');
?>
