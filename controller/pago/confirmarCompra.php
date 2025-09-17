<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: ../../view/auth/login.php');
    exit;
}

require '../../config/conexion.php';

// Recibir JSON de productos
$productosJson = $_POST['productos'] ?? null;
if (!$productosJson) {
    echo "No se recibieron productos para confirmar.";
    exit;
}

$productos = json_decode($productosJson, true);
if (!is_array($productos)) {
    echo "Error al decodificar productos.";
    exit;
}

// Obtener métodos de pago
$metodosPago = [];
$result = $conn->query("SELECT * FROM metodo_pago");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $metodosPago[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Confirmar Compra</title>
    <link rel="stylesheet" href="../../public/css/confirmarCompra.css">
</head>

<body>
    <h1>Confirma tu compra</h1>

    <div class="checkout-container">
        <!-- Resumen -->
        <div class="card">
            <h2>Resumen de compra</h2>
            <div id="productos-container"></div>
        </div>

        <!-- Detalles -->
        <div class="card">
            <h2>Detalles de entrega</h2>
            <form id="form-compra">
                <label for="metodo_pago">Método de pago</label>
                <select id="metodo_pago" name="metodo_pago" required>
                    <option value="">Selecciona método de pago</option>
                    <?php foreach ($metodosPago as $m): ?>
                        <option value="<?= $m['ID'] ?>"><?= htmlspecialchars($m['pago']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="valor_envio">Valor de envío</label>
                <input type="number" id="valor_envio" name="valor_envio" min="0" value="" placeholder="0">

                <label for="nota">Nota adicional (opcional)</label>
                <textarea id="nota" name="nota" placeholder="Instrucciones especiales para la entrega..."></textarea>

                <button id="confirmar-compra">Confirmar compra</button>
            </form>
        </div>
    </div>

    <div id="mensaje"></div>

    <div class="checkout-footer">
        Compra segura • Entrega garantizada • Soporte 24/7
    </div>

    <script>
        const productos = <?php echo json_encode($productos, JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script src="../../public/js/confirmarCompra.js"></script>
</body>

</html>