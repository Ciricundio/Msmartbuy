<?php
session_start();
require '../../config/conexion.php';

// Verificar sesión
if (!isset($_SESSION['ID'])) {
    header('Location: ../view/auth/login.php');
    exit();
}

$idUsuario = $_SESSION['ID'];

// Obtener productos del carrito
$sql = "SELECT p.ID, p.nombre, p.marca, p.descripcion, p.foto, p.precio_unitario, p.descuento, 
               cp.cantidad, 
               (p.precio_unitario * (1 - p.descuento/100)) AS precio_final
        FROM carrito_producto cp
        JOIN producto p ON cp.producto_ID = p.ID
        WHERE cp.carrito_ID IN (SELECT ID FROM carrito WHERE usuario_ID = ? AND estado = 'Disponible')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$productos = $result->fetch_all(MYSQLI_ASSOC);

// Calcular total
$total = 0;
foreach ($productos as $producto) {
    $total += $producto['precio_final'] * $producto['cantidad'];
}

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actualizar_carrito'])) {
        // Actualizar cantidades
        foreach ($_POST['cantidad'] as $productoId => $cantidad) {
            $cantidad = intval($cantidad);
            if ($cantidad > 0) {
                $sql = "UPDATE carrito_producto 
                        SET cantidad = ? 
                        WHERE producto_ID = ? 
                        AND carrito_ID IN (SELECT ID FROM carrito WHERE usuario_ID = ? AND estado = 'Disponible')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $cantidad, $productoId, $idUsuario);
                $stmt->execute();
            }
        }
        header("Location: carrito.php");
        exit();
    } elseif (isset($_POST['eliminar_producto'])) {
        // Eliminar producto del carrito
        $productoId = $_POST['producto_id'];
        $sql = "DELETE FROM carrito_producto 
                WHERE producto_ID = ? 
                AND carrito_ID IN (SELECT ID FROM carrito WHERE usuario_ID = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $productoId, $idUsuario);
        $stmt->execute();
        header("Location: carrito.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito - Msmartbuy</title>
    <link rel="icon" href="../../public/img/Icono/Icon_cnt.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/carrito.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../home/home.php">
                <img src="../../public/img/Icono/Icon_cnt.svg" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Msmartbuy
            </a>
            <div class="ms-auto d-flex">
                <a href="../home/home.php" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left"></i> Seguir comprando
                </a>
                <a href="#" class="btn btn-outline-primary position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if (count($productos) > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= count($productos) ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container p-4 mb-4">
                    <h2 class="fw-bold mb-4">Mi Carrito</h2>

                    <?php if (empty($productos)): ?>
                        <div class="empty-cart text-center">
                            <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
                            <h3 class="mb-3">Tu carrito está vacío</h3>
                            <p class="text-muted mb-4">Agrega productos para comenzar a comprar</p>
                            <a href="../home/home.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i> Ver productos
                            </a>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="carrito.php">
                            <?php foreach ($productos as $producto): ?>
                                <div class="product-card p-3 d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="../../public/img/products/<?= htmlspecialchars($producto['foto']) ?>"
                                            alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                            class="product-img">
                                        <?php if ($producto['descuento'] > 0): ?>
                                            <span class="discount-badge">-<?= $producto['descuento'] ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                        <p class="text-muted small mb-1"><?= htmlspecialchars($producto['marca']) ?></p>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group me-3" style="width: 120px;">
                                                <button class="btn btn-outline-secondary decrement" type="button">-</button>
                                                <input type="number"
                                                    name="cantidad[<?= $producto['ID'] ?>]"
                                                    value="<?= $producto['cantidad'] ?>"
                                                    min="1"
                                                    class="form-control text-center quantity-input">
                                                <button class="btn btn-outline-secondary increment" type="button">+</button>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold">$<?= number_format($producto['cantidad'] * $producto['precio_final'], 0, ',', '.') ?></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <button type="submit"
                                            name="eliminar_producto"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <input type="hidden" name="producto_id" value="<?= $producto['ID'] ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>


                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($productos)): ?>
                <div class="col-lg-4">
                    <div class="cart-container p-4 summary-card">
                        <h3 class="fw-bold mb-4">Resumen de compra</h3>

                        <div class="mb-3 d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span class="fw-bold">$<?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <span>Envío:</span>
                            <span class="fw-bold">$0</span>
                        </div>

                        <hr>

                        <div class="mb-4 d-flex justify-content-between">
                            <span class="fw-bold">Total:</span>
                            <span class="fw-bold text-success">$<?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <form method="POST" action="carrito.php">
                            <button type="submit" name="finalizar_compra" id="finalizar_compra" class="btn btn-checkout btn-lg w-100 text-white">
                                <i class="fas fa-credit-card me-2"></i> Realizar pago
                            </button>
                        </form>

                        <div class="mt-3 small text-muted">
                            <i class="fas fa-lock me-2"></i> Tu información está protegida
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Incrementar/decrementar cantidad
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input[type=number]');
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input[type=number]');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });

        // Evitar números negativos
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) this.value = 1;
            });
        });

        document.getElementById('finalizar_compra').addEventListener('click', async () => {
            // Obtener productos del carrito (puedes usar AJAX a listarCarrito.php)
            const res = await fetch('../../listarCarrito.php');
            const productos = await res.json();

            if (productos.error || productos.length === 0) {
                alert('No hay productos en el carrito para comprar.');
                return;
            }

            // Crear formulario para enviar POST con JSON a confirmarCompra.php
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../controller/pago/confirmarCompra.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'productos';
            input.value = JSON.stringify(productos);

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>

</html>