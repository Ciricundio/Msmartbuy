<?php
session_start();
require '../../config/conexion.php';

// Configuración de errores para debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Log para debugging
error_log("Iniciando procesarCompra.php");

if (!isset($_SESSION['ID'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

$userId = $_SESSION['ID'];
error_log("Usuario ID: " . $userId);

$input = file_get_contents("php://input");
error_log("Input recibido: " . $input);

$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Manejo directo de la estructura de productos
$productos = null;
if (isset($data['productos']) && is_array($data['productos'])) {
    $productos = $data['productos'];
}

if (!$productos || !is_array($productos) || empty($productos)) {
    echo json_encode(['success' => false, 'error' => 'No se encontraron productos válidos para procesar']);
    exit;
}

error_log("Productos a procesar: " . count($productos));

$metodoPago = $data['metodo_pago'] ?? null;
$valorEnvio = (float) ($data['valor_envio'] ?? 0);
$nota = $data['nota'] ?? "";

// Validar método de pago
if (!$metodoPago) {
    echo json_encode(['success' => false, 'error' => 'Método de pago requerido']);
    exit;
}

// Calcular totales
$total = 0;
foreach ($productos as $i => $p) {
    // Flexibilidad en el nombre del campo ID
    $idProducto = null;
    if (isset($p['ID'])) {
        $idProducto = $p['ID'];
    } elseif (isset($p['id'])) {
        $idProducto = $p['id'];
    } elseif (isset($p['producto_id'])) {
        $idProducto = $p['producto_id'];
    }
    
    if (!$idProducto) {
        error_log("Producto [$i] sin ID válido: " . print_r($p, true));
        echo json_encode(['success' => false, 'error' => "Producto en posición $i sin ID válido"]);
        exit;
    }
    
    // Actualizar el producto con el ID normalizado
    $productos[$i]['ID'] = $idProducto;
    
    $precio = (float) ($p['precio_final'] ?? $p['precio_unitario'] ?? 0);
    $cantidad = (int) ($p['cantidad'] ?? 1);
    
    if ($precio <= 0 || $cantidad <= 0) {
        echo json_encode(['success' => false, 'error' => 'Precio o cantidad inválidos']);
        exit;
    }
    
    $total += $precio * $cantidad;
}
$totalFinal = $total + $valorEnvio;
$subtotal = $precio * $cantidad;


error_log("Total calculado: " . $totalFinal);

// Verificar conexión a BD
if (!isset($mysqli)) {
    if (isset($conn)) {
        $mysqli = $conn;
    } else {
        echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
        exit;
    }
}

$mysqli->begin_transaction();

try {
    // Verificar que el método de pago existe
    $stmtVerificar = $mysqli->prepare("SELECT ID FROM metodo_pago WHERE ID = ?");
    $stmtVerificar->bind_param("i", $metodoPago);
    $stmtVerificar->execute();
    $result = $stmtVerificar->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Método de pago no válido");
    }
    $stmtVerificar->close();
    $estado = "PENDIENTE";
    // Insertar factura
    $stmt = $mysqli->prepare("INSERT INTO factura (usuario_ID, fecha, metodo_pago_ID, valor_venta, valor_envio, total, estado, nota) 
                              VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error prepare factura: " . $mysqli->error);
    }
    
    $stmt->bind_param("iidddss", $userId, $metodoPago, $subtotal, $valorEnvio, $totalFinal, $estado, $nota);
    if (!$stmt->execute()) {
        throw new Exception("Error ejecutar factura: " . $stmt->error);
    }
    
    $facturaId = $stmt->insert_id;
    $stmt->close();
    
    if (!$facturaId) {
        throw new Exception("No se pudo obtener el ID de la factura");
    }

    error_log("Factura creada con ID: " . $facturaId);

    // Insertar detalle
    $stmtDetalle = $mysqli->prepare("INSERT INTO detalle_factura (factura_ID, producto_ID, cantidad_producto, subtotal) 
                                     VALUES (?, ?, ?, ?)");
    if (!$stmtDetalle) {
        throw new Exception("Error prepare detalle: " . $mysqli->error);
    }

    foreach ($productos as $p) {
        $idProducto = (int) $p['ID'];
        $cantidad = (int) ($p['cantidad'] ?? 1);
        $precio = (float) ($p['precio_final'] ?? $p['precio_unitario'] ?? 0);

        // Verificar que el producto existe
        $stmtProd = $mysqli->prepare("SELECT ID FROM producto WHERE ID = ?");
        $stmtProd->bind_param("i", $idProducto);
        $stmtProd->execute();
        $resultProd = $stmtProd->get_result();
        if ($resultProd->num_rows === 0) {
            throw new Exception("Producto ID $idProducto no existe");
        }
        $stmtProd->close();

        $stmtDetalle->bind_param("iiid", $facturaId, $idProducto, $cantidad, $subtotal);
        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al insertar detalle: " . $stmtDetalle->error);
        }
    }
    $stmtDetalle->close();

    // Limpiar carrito - Verificar si existe antes de borrar
    $stmtCarrito = $mysqli->prepare("SELECT ID FROM carrito WHERE usuario_ID = ?");
    $stmtCarrito->bind_param("i", $userId);
    $stmtCarrito->execute();
    $resultCarrito = $stmtCarrito->get_result();
    
    if ($resultCarrito->num_rows > 0) {
        // Borrar productos del carrito
        $stmt = $mysqli->prepare("DELETE cp FROM carrito_producto cp
                                  INNER JOIN carrito c ON cp.carrito_ID = c.ID
                                  WHERE c.usuario_ID = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        // Borrar el carrito
        $stmt = $mysqli->prepare("DELETE FROM carrito WHERE usuario_ID = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    $stmtCarrito->close();

    $mysqli->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'La compra se realizó con éxito',
        'factura_id' => $facturaId
    ]);

} catch (Exception $e) {
    $mysqli->rollback();
    error_log("Error en procesarCompra: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}