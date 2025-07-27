<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "adminmsmart";
$password = "LLy01215c";
$dbname = "msmartbuy";

// Método 1: Conexión mediante MySQLi orientado a objetos
function conectar_mysqli_oo() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    return $conn;
}

// Método 2: Conexión mediante MySQLi procedural
function conectar_mysqli_procedural() {
    global $servername, $username, $password, $dbname;
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

// Método 3: Conexión mediante PDO
function conectar_pdo() {
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Conexión fallida: " . $e->getMessage());
    }
}

// Elige uno de los métodos
$conn = conectar_mysqli_procedural();

