<?php
header('Content-Type: application/json');
require_once 'config/conexion.php';

try {
    session_start();
    $userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_POST['user_id']) ? intval($_POST['user_id']) : 0);
    $paymentId = isset($_POST['payment_id']) ? $_POST['payment_id'] : 'PAGO_' . time();
    $preferenceId = isset($_POST['preference_id']) ? $_POST['preference_id'] : '';

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    // Iniciar transacción
    $conn->begin_transaction();

    // Obtener items del carrito para crear la factura
    $sql = "SELECT cp.*, p.nombre, p.precio_unitario, p.descuento, c.ID as carrito_id
            FROM carrito_producto cp
            JOIN carrito c ON cp.carrito_ID = c.ID
            JOIN producto p ON cp.producto_ID = p.ID
            WHERE c.usuario_ID = ? AND p.estado = 'Disponible'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Carrito vacío");
    }

    $items = [];
    $total = 0;
    $carritoId = null;

    while ($row = $result->fetch_assoc()) {
        $carritoId = $row['carrito_id'];
        $precioFinal = $row['descuento'] ? 
            $row['precio_unitario'] * (1 - $row['descuento'] / 100) : 
            $row['precio_unitario'];
        
        $items[] = [
            'producto_id' => $row['producto_ID'],
            'nombre' => $row['nombre'],
            'cantidad' => $row['cantidad'],
            'precio_unitario' => $row['precio_unitario'],
            'descuento' => $row['descuento'],
            'precio_final' => $precioFinal,
            'subtotal' => $precioFinal * $row['cantidad']
        ];
        
        $total += $precioFinal * $row['cantidad'];
    }

    // Crear factura
    $insertFactura = "INSERT INTO factura (usuario_ID, fecha, total, estado, payment_id) VALUES (?, CURDATE(), ?, 'completado', ?)";
    $stmtFactura = $conn->prepare($insertFactura);
    $stmtFactura->bind_param("ids", $userId, $total, $paymentId);
    $stmtFactura->execute();
    $facturaId = $conn->insert_id;

    // Crear detalles de factura
    $insertDetalle = "INSERT INTO detalle_factura (factura_ID, producto_ID, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($insertDetalle);

    foreach ($items as $item) {
        $stmtDetalle->bind_param("iiidd", 
            $facturaId, 
            $item['producto_id'], 
            $item['cantidad'], 
            $item['precio_final'], 
            $item['subtotal']
        );
        $stmtDetalle->execute();
    }

    // Vaciar carrito
    $emptyCart = $conn->prepare("DELETE FROM carrito_producto WHERE carrito_ID = ?");
    $emptyCart->bind_param("i", $carritoId);
    $emptyCart->execute();

    // Confirmar transacción
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Tienes una compra pendiente. Puedes verla en "Mis compras"',
        'factura_id' => $facturaId,
        'total' => $total
    ]);

} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
