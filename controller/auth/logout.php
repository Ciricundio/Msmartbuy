<?php
session_start();            // Inicia la sesión
session_unset();            // Elimina todas las variables de sesión
session_destroy();          // Destruye la sesión
header("Location: ../../view/auth/login.php"); // Redirige al inicio (ajusta la ruta si es necesario)
exit();
