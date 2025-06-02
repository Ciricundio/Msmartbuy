<?php
session_start();
if (!isset($_SESSION['nombre']) || !isset($_SESSION['apellido']) || !isset($_SESSION['correo'])) {
    header("Location: ../../view/view/auth/signup.php");
    exit();
}