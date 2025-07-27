<?php
header('Content-Type: application/json');
require_once 'config/conexion.php';

try {
    session_start();
    $userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_POST['user_id']) ? intval($_POST['user_id']) : 0);

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    // Obtener items del carrito
    $sql = "SELECT cp.*, p.nombre, p.precio_unitario, p.descuento
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

    while ($row = $result->fetch_assoc()) {
        $precioFinal = $row['descuento'] ? 
            $row['precio_unitario'] * (1 - $row['descuento'] / 100) : 
            $row['precio_unitario'];
        
        $items[] = [
            'id' => $row['producto_ID'],
            'title' => $row['nombre'],
            'quantity' => $row['cantidad'],
            'currency_id' => 'COP',
            'unit_price' => $precioFinal
        ];
        
        $total += $precioFinal * $row['cantidad'];
    }

    // Simular preferencia de pago (en producción usar SDK de Mercado Pago)
    $preference = [
        'id' => 'PREF_' . time() . '_' . $userId,
        'items' => $items,
        'total' => $total,
        'back_urls' => [
            'success' => 'https://msmartbuy.com/confirmarPago.php',
            'failure' => 'https://msmartbuy.com/pagoFallido.php',
            'pending' => 'https://msmartbuy.com/pagoPendiente.php'
        ],
        'auto_return' => 'approved',
        'notification_url' => 'https://msmartbuy.com/webhook.php'
    ];

    echo json_encode([
        'success' => true,
        'data' => $preference
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
