<?php
session_start();
require '../../config/conexion.php';

// Validar que exista la sesión obligatoria
if (!isset($_SESSION['ID'])) {
    // En producción podrías redirigir al login
    header('Location: ../../view/auth/login.php');
}

$idUsuario = $_SESSION['ID'];

// Obtener nombre del usuario
$sqlUsuario = "SELECT * FROM usuario WHERE ID = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("i", $idUsuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows === 0) {
    die("Error: Usuario no encontrado.");
}

$usuario = $resultUsuario->fetch_assoc();
$nombreUsuario = $usuario['nombre'];
$apellidoUsuario = $usuario['apellido'];



// Consulta de productos en promoción
$sql = "SELECT * FROM producto WHERE descuento > 0 ORDER BY descuento DESC LIMIT 8";
$stmt = $conn->query($sql);
$productos = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Msmartbuy</title>
    <link rel="icon" href="../../public/img/Icono/Icon_cnt.svg">
    <link rel="stylesheet" href="../../public/css/home.css">
    <!-- Incluir Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=close" />

</head>
<body>
    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="logo-container">
                <div class="logo">
                    <img src="../../public/img/Icono/logo.png" alt="Icono del cliente en Msmartbuy">
                </div>
                <span class="logo-text">Msmartbuy</span>
            </div>

            <nav class="sidebar-nav">
                <button class="nav-button active">
                    <i class="fas fa-home"></i>
                    Inicio
                </button>
                <button class="nav-button">
                    <i class="fas fa-bell"></i>
                    Notificaciones
                </button>
                <button class="nav-button">
                    <i class="fas fa-shopping-bag"></i>
                    Mis compras
                </button>
                <button class="nav-button">
                    <i class="fas fa-th"></i>
                    Categorías
                </button>
                <button class="nav-button">
                    <i class="fas fa-credit-card"></i>
                    Suscripción
                </button>
                <button class="nav-button">
                    <i class="fas fa-map-marker-alt"></i>
                    Mi ubicación
                </button>
                <button class="nav-button">
                    <i class="fas fa-shield-alt"></i>
                    Pagos seguros
                </button>
                <button class="nav-button">
                    <i class="fas fa-user"></i>
                    Soporte
                </button>
            </nav>

            <!-- User Profile -->
            <div class="user-profile">
                <div class="profile-card">
                    <div class="profile-avatar">CM</div>
                    <span class="profile-name"><?php echo $nombreUsuario . " " . $apellidoUsuario; ?></span>
                </div>
                <form action="../../controller/auth/logout.php" method="get">
                    <button class="nav-button" type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Header -->
        <div class="header">
            <div class="header-content">

                <div class="header-x bordear">
                    <button class="icon-button">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>

                <div class="search-container bordear">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input class="bordear" type="text" placeholder="Busca tu producto aquí...">
                    </div>
                </div>

                <div class="header-actions bordear">
                    <button class="icon-button">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                    <button class="icon-button">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Hero Banner -->
            <div class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">¡Hola, <?php echo $nombreUsuario?>!</h1>
                    <p class="hero-subtitle">Aquí encontrarás todo lo que quieras!</p>
                </div>
                <div class="hero-image">
                    <div class="hero-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>

            <!-- Product Categories -->
            <div class="section">
            
                <h2 class="section-title">Producto específico</h2>
                <div class="category-grid">
                    <div class="category-card">
                        <i class="fas fa-box"></i>
                        <span>Productos</span>
                    </div>
                    <div class="category-card">
                        <i class="fas fa-tag"></i>
                        <span>Ofertas</span>
                    </div>
                    <div class="category-card">
                        <i class="fas fa-chart-line"></i>
                        <span>Tendencias</span>
                    </div>
                    <div class="category-card">
                        <i class="fas fa-truck"></i>
                        <span>Envío</span>
                    </div>
                </div>
            </div>

            <section class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title">Descuentos</h2>
                    <a href="#" class="section-link">mostrar todos</a>
                </div>

                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <?php foreach ($productos as $p): ?>
                        <div class="col">
                            <div class="product-card">
                                <div>
                                    <button class="favorite-button">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <div class="product-image">
                                        <img src="../../public/img/products/<?= $p['foto'] ?>" class="card-img-top img-fluid" style="max-height: 100px; object-fit: contain;">
                                    </div>
                                    
                                </div>
                                <div class="card-body">
                                    <small class="product-brand"><?= strtoupper($p['marca']) ?></small>
                                    <h6 class="product-name"><?= $p['nombre'] ?></h6>
                                    <div class="product-price">
                                        <span class="fw-bold">$ <?= number_format($p['precio_unitario'] * (1 - $p['descuento'] / 100), 0, ',', '.') ?></span>
                                        <span class="porcentaje">-<?= $p['descuento'] ?>%</span>
                                        <small class="text-muted text-decoration-line-through">$<?= number_format($p['precio_unitario'], 0, ',', '.') ?></small>
                                    </div>

                                    <div class="card-footer bg-transparent border-0">
                                        <?php if (!empty($p['agregado'])): ?>
                                        <button class="btn btn-warning w-100">Agregado 🛒</button>
                                        <?php else: ?>
                                        <button class="add-button">Agregar 🛒</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </section>

        </main>

        <!-- Right Sidebar - Favorites -->
        <aside class="favorites-sidebar">

            <div class="user-info">
                <i class="fas fa-chevron-right"></i>
                <div>
                    <div class="user-title">Mis favoritos</div>
                    <div class="user-subtitle">En Tu Lista Tienes | 5 Productos</div>

                </div>
            </div>

            <div class="favorites-container">
                <!-- Aquí se mostrarán los productos favoritos -->
            </div>
        </aside>

        <?php require '../template/footer.php'?>

    </div>

    <script src="../../controller/dashboard/home.js"></script>
</body>
</html>