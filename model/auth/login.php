<?php
session_start();
require '../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pasword']; // Asegúrate que el campo en el formulario se llama así

    // Preparar la consulta con MySQLi
    $query = "SELECT ID, correo, contrasena FROM usuario WHERE correo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verifica la contraseña hasheada
        if (password_verify($password, $user['contrasena'])) {
            $_SESSION['ID'] = $user['ID'];
            $_SESSION['email'] = $user['correo'];

            header("Location: ../../view/home/welcome.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no encontrado.";
    }
}
