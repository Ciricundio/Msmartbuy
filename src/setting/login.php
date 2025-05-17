<?php
// Iniciar la sesión
session_start();

// Incluir el archivo que tiene la conexión a la base de datos
require '../../Conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $email = $_POST['email'];
    $password = $_POST['pasword'];

    // Consulta SQL para obtener el usuario con el correo proporcionado
    $query = "SELECT IDusuario, contrasena FROM usuario WHERE email = :email";

    // Preparar la consulta usando PDO
    $stmt = $conn->prepare($query);

    // Usar bindValue en lugar de bindParam
    $stmt->bindValue(':email', $email);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se obtuvo un resultado
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // Verificar la contraseña (considerando que está encriptada)
        if ( $password === $row['contrasena']) {
            // Contraseña correcta: iniciar la sesión
            $_SESSION['IDusuario'] = $row['IDusuario'];
            $_SESSION['email'] = $email;

            // Redirigir al usuario a la página principal
            header("Location: ../bienvenida.html");
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Correo no encontrado.";
    }
}