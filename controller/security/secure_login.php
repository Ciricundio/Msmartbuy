<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si las variables de sesión necesarias están establecidas
if (!isset($_SESSION['ID']) || !isset($_SESSION['email']) || !isset($_SESSION['rol'])) {
    // Si el usuario no está logueado, redirige a la página de login
    header("Location: ../../view/auth/login.php");
    exit();
}