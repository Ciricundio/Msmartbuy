<?php
session_start();
include '../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Paso 1: Datos personales iniciales
    if (isset($_POST['nombre'])) {
        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellido'] = $_POST['apellido'];
        $_SESSION['correo'] = $_POST['correo'];
        $_SESSION['telefono'] = $_POST['telefono'];
        $_SESSION['zona'] = $_POST['zone'];
        $_SESSION['contrasena'] = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
        header("Location: ../../view/form/role.php");
        exit();
    }

    // Paso 2: Rol
    if (isset($_POST['rol'])) {
        $_SESSION['rol'] = $_POST['rol'];
        header("Location: ../../view/form/gender.php");
        exit();
    }

    // Paso 3: Género
    if (isset($_POST['genero'])) {
        $_SESSION['genero'] = $_POST['genero'];
        header("Location: ../../view/form/date.php");
        exit();
    }

    // Paso 4: Fecha y registro completo
    if (isset($_POST['fecha_nacimiento'])) {
        $_SESSION['fecha_nacimiento'] = $_POST['fecha_nacimiento'];

        // Insertar en tabla usuarios
        $sql_usuario = "INSERT INTO usuario (nombre, apellido, correo, contrasena, telefono, rol, genero, fecha_nacimiento)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_usuario = $conn->prepare($sql_usuario);
        $stmt_usuario->bind_param(
            "ssssssss",
            $_SESSION['nombre'],
            $_SESSION['apellido'],
            $_SESSION['correo'],
            $_SESSION['contrasena'],
            $_SESSION['telefono'],
            $_SESSION['rol'],
            $_SESSION['genero'],
            $_SESSION['fecha_nacimiento']
        );

        if ($stmt_usuario->execute()) {
            $id_usuario = $stmt_usuario->insert_id;

            // Insertar en tabla ubicacion
            $sql_ubicacion = "INSERT INTO ubicacion (zona) VALUES (?)";
            $stmt_ubicacion = $conn->prepare($sql_ubicacion);
            $stmt_ubicacion->bind_param("s", $_SESSION['zona']);

            if ($stmt_ubicacion->execute()) {
                $id_ubicacion = $stmt_ubicacion->insert_id;

                // Insertar en la tabla de relación usuario_ubicacion
                $sql_relacion = "INSERT INTO usuario_ubicacion (usuario_ID, ubicacion_ID) VALUES (?, ?)";
                $stmt_relacion = $conn->prepare($sql_relacion);
                $stmt_relacion->bind_param("ii", $id_usuario, $id_ubicacion);
                $stmt_relacion->execute();

                session_destroy(); // Limpiar datos
                header("Location: ../../view/home/welcome.php");
            } else {
                echo "Error al registrar ubicación: " . $stmt_ubicacion->error;
            }
        } else {
            echo "Error al registrar usuario: " . $stmt_usuario->error;
        }

        exit();
    }
}
