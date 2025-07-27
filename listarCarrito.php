<?php
// Configurar headers para CORS y JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

// Iniciar sesión antes de incluir la conexión
session_start();

require_once 'config/conexion.php';

try {
    // Verificar que la sesión esté activa
    if (!isset($_SESSION['ID']) || empty($_SESSION['ID'])) {
        throw new Exception("Sesión no válida. Por favor, inicia sesión nuevamente.");
    }
    
    $userId = $_SESSION['ID'];

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    $sql = "SELECT 
                p.ID, 
                p.nombre, 
                p.marca, 
                p.precio_unitario, 
                p.descuento, 
                p.foto, 
                p.descripcion,
                cp.cantidad,
                cp.subtotal,
                c.categoria,
                (p.precio_unitario * (1 - COALESCE(p.descuento, 0) / 100)) as precio_final
            FROM carrito_producto cp
            JOIN carrito car ON cp.carrito_ID = car.ID
            JOIN producto p ON cp.producto_ID = p.ID
            JOIN categoria c ON p.categoria_ID = c.ID
            WHERE car.usuario_ID = ? AND p.estado = 'Disponible'
            ORDER BY car.fecha_creacion DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = [];
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        $itemTotal = $row['precio_final'] * $row['cantidad'];
        $row['item_total'] = $itemTotal;
        $total += $itemTotal;
        $cartItems[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $cartItems,
        'total_items' => count($cartItems),
        'total_amount' => $total
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
