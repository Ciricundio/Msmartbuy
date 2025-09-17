<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';

try {
    session_start();
    $userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_GET['user_id']) ? intval($_GET['user_id']) : 0);

    if ($userId <= 0) {
        throw new Exception("Usuario no autenticado");
    }

    $sql = "SELECT f.ID, f.fecha, f.total, f.estado,
                   GROUP_CONCAT(DISTINCT p.nombre SEPARATOR ', ') as productos,
                   COUNT(DISTINCT df.producto_ID) as total_productos
            FROM factura f
            JOIN detalle_factura df ON f.ID = df.factura_ID
            JOIN producto p ON df.producto_ID = p.ID
            WHERE f.usuario_ID = ?
            GROUP BY f.ID
            ORDER BY f.ID DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $purchases = [];
    while ($row = $result->fetch_assoc()) {
        // Obtener detalles de cada factura
        $detailsSql = "SELECT df.producto_ID, p.nombre, p.foto, df.cantidad_producto, df.subtotal
                        FROM detalle_factura df
                        JOIN producto p ON df.producto_ID = p.ID
                        WHERE df.factura_ID = ?";
        
        $detailsStmt = $conn->prepare($detailsSql);
        $detailsStmt->bind_param("i", $row['ID']);
        $detailsStmt->execute();
        $detailsResult = $detailsStmt->get_result();
        
        $details = [];
        while ($detail = $detailsResult->fetch_assoc()) {
            $details[] = $detail;
        }
        
        $row['detalles'] = $details;
        $purchases[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $purchases,
        'total' => count($purchases)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
