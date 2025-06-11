<?php
session_start();
require '../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pasword']; // Asegúrate que el campo en el formulario se llama así

    // Preparar la consulta con MySQLi
    $query = "SELECT ID, correo, contrasena, rol FROM usuario WHERE correo = ?"; // Asegúrate de seleccionar el 'rol'
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verifica la contraseña hasheada
        if (password_verify($password, $user['contrasena'])) {
            // Autenticación exitosa
            $_SESSION['ID'] = $user['ID'];
            $_SESSION['email'] = $user['correo'];
            $_SESSION['rol'] = $user['rol']; // ¡AQUÍ ESTÁ EL CAMBIO CLAVE! Guardar el rol en la sesión

            header("Location: ../../view/home/welcome.php");
            exit(); // ¡Muy importante! Siempre usa exit() después de un header Location
        } else {
            // Contraseña incorrecta, podrías redirigir de vuelta al login con un mensaje de error
            echo "Contraseña incorrecta.";
        }
    } else {
        // Correo no encontrado, podrías redirigir de vuelta al login con un mensaje de error
        echo "Correo no encontrado.";
    }
}
// Si la petición no es POST, o si falla la autenticación y no hay una redirección,
// este script simplemente no hace nada, o podrías tener un fallback.
