<?php
session_start();
require '../../config/conexion.php';

$sql = "SELECT * FROM producto WHERE descuento > 0 ORDER BY descuento DESC LIMIT 10";
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=close" />

</head>
<body>
    <div class="container">

        <div class="main-container">
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
                        <span class="profile-name">Ciro Muñoz</span>
                    </div>
                    <form action="../../controller/auth/logout.php" method="get">
                        <button class="nav-button" type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content">

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

                <!-- Hero Banner -->
                <div class="hero-banner">
                    <div class="hero-content">
                        <h1 class="hero-title">¡Hola, Ciro!</h1>
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
                        <h4>Descuentos</h4>
                        <a href="#" class="text-muted">mostrar todos</a>
                    </div>
                    <div class="row row-cols-2 row-cols-md-4 g-3">
                        <?php foreach ($productos as $p): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative p-3 pb-0">
                                <img src="<?= $p['imagen'] ?>" class="card-img-top img-fluid" style="max-height: 100px; object-fit: contain;">
                                <button class="btn btn-light rounded-circle position-absolute top-0 end-0 m-2 shadow-sm">
                                ❤️
                                </button>
                            </div>
                            <div class="card-body">
                                <small class="text-uppercase text-muted"><?= strtoupper($p['marca']) ?></small>
                                <h6 class="card-title"><?= $p['nombre_producto'] ?></h6>
                                <p class="mb-1 fw-bold text-dark">$ <?= number_format($p['precio_final'], 0, ',', '.') ?></p>
                                <small class="text-muted text-decoration-line-through">$ <?= number_format($p['precio_original'], 0, ',', '.') ?></small>
                                <span class="ms-2 text-success fw-bold"><?= $p['descuento'] ?>%</span>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <?php if (!empty($p['agregado'])): ?>
                                <button class="btn btn-warning w-100">Agregado 🛒</button>
                                <?php else: ?>
                                <button class="btn btn-success w-100">Agregar 🛒</button>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>


                <!-- Discounts Section -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">Descuentos</h2>
                        <a href="#" class="section-link">mostrar todos</a>
                    </div>
                    <div class="product-grid">
                        <div class="product-card">
                            <button class="favorite-button">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="placeholder.jpg" alt="Producto ZENU">
                            </div>
                            <div class="product-brand">ZENU</div>
                            <div class="product-name">Lomo De Atún</div>
                        </div>

                        <div class="product-card">
                            <button class="favorite-button active">
                                <i class="fas fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="placeholder.jpg" alt="Producto DERSA">
                            </div>
                            <div class="product-brand">DERSA</div>
                            <div class="product-name">Detergente</div>
                        </div>

                        <div class="product-card">
                            <button class="favorite-button">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="placeholder.jpg" alt="Producto COLGATE">
                            </div>
                            <div class="product-brand">COLGATE</div>
                            <div class="product-name">Crema Colgate</div>
                        </div>

                        <div class="product-card">
                            <button class="favorite-button">
                                <i class="far fa-heart"></i>
                            </button>
                            <div class="product-image">
                                <img src="placeholder.jpg" alt="Producto PREMIER">
                            </div>
                            <div class="product-brand">PREMIER</div>
                            <div class="product-name">Aceite Premier</div>
                        </div>
                    </div>
                </div>
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
                    <!-- Favorite Item 1 -->
                    <div class="favorite-item">
                        <div class="favorite-image-container">
                            <img src="placeholder.jpg" alt="DERSA Detergente" class="favorite-image">
                            <i class="fas fa-heart favorite-icon"></i>
                        </div>
                        <div class="favorite-details">
                            <div class="product-brand">DERSA</div>
                            <div class="product-name">Detergente Multiusos 500gr</div>
                            <div class="price-container">
                                <span class="current-price">$ 5.448</span>
                                <span class="discount-badge">-15%</span>
                            </div>
                            <div class="original-price">$ 6.410</div>
                            <button class="add-button">Agregar 🛒</button>
                        </div>
                    </div>

                    <!-- Favorite Item 2 -->
                    <div class="favorite-item">
                        <div class="favorite-image-container">
                            <img src="placeholder.jpg" alt="TAKA TAKA Ramen" class="favorite-image">
                            <i class="fas fa-heart favorite-icon"></i>
                            <span class="new-badge">NEW</span>
                        </div>
                        <div class="favorite-details">
                            <div class="product-brand">TAKA TAKA</div>
                            <div class="product-name">Shin Ramyun Ramen Corea Paq...</div>
                            <div class="price-container">
                                <span class="current-price">$ 20.070</span>
                                <span class="discount-badge">-5%</span>
                            </div>
                            <div class="original-price">$ 30.600</div>
                            <button class="add-button">Agregar 🛒</button>
                        </div>
                    </div>
                </div>
            </aside>

        </div>

    </div>

    <script src="../../controller/dashboard/home.js"></script>
</body>
</html>