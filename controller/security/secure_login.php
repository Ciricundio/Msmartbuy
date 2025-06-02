<?php
session_start();

// Si no hay sesión activa, redirige al login
if (!isset($_SESSION['ID'])) {
    header("Location: ../../view/auth/login.php");
    exit();
}