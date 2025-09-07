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

    <!-- React CDN -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        /* Search Results Styles */
        .search-results-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 12px;
            border-radius: 4px;
        }

        .product-image-section{
            height: 80%;
            width: 100%;
            background: white;
            position: relative;
            overflow: hidden;
            display: flex;              /* activa flexbox */
            justify-content: center;
        }

        /* Modal styles */
        .product-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-modal-content {
            background: white;
            border-radius: 12px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 1;
            color: #666;
        }

        .product-detail-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .product-detail-layout {
                grid-template-columns: 1fr;
            }
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background: #ff6b35;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        /* Horizontal Scroll Styles */
        .products-scroll-container {
            overflow-x: auto;
            overflow-y: hidden;
            padding: 10px 0;
            margin: 0 -15px;
        }

        .products-scroll-container::-webkit-scrollbar {
            height: 8px;
        }

        .products-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .products-scroll-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .products-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .products-horizontal-list {
            display: flex;
            gap: 15px;
            padding: 0 15px;
            min-width: max-content;
        }

        .product-card-horizontal {
            flex: 0 0 250px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .product-card-horizontal:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .product-card-horizontal .product-image {
            position: relative;
            height: 180px;
            overflow: hidden;
            width: 100%;
        }

        .product-card-horizontal .product-image img {
            height: 100%;
            object-fit: cover;
        }

        .product-card-horizontal .favorite-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-card-horizontal .favorite-button:hover {
            background: white;
            transform: scale(1.1);
        }

        .product-card-horizontal .card-body {
            padding: 15px;
        }

        .product-card-horizontal .product-brand {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-card-horizontal .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.3;
            height: 35px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-card-horizontal .product-price {
            margin-bottom: 12px;
        }

        .product-card-horizontal .add-button {
            width: 100%;
            padding: 8px 12px;
            background: #2ecb70;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-card-horizontal .add-button:hover {
            background: #24a159;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 15px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        .section-link {
            color: #2ecb70;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .section-link:hover {
            color: #24a159;
            text-decoration: none;
        }
    </style>

</head>

<body>
    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="logo-container">
                <div class="logo">
                    <img src="../../public/img/Icono/Icon_cnt.svg" alt="Icono del cliente en Msmartbuy">
                </div>
                <span class="logo-text">Msmartbuy</span>
            </div>

            <nav class="sidebar-nav">
                <button class="nav-button active">
                    <i class="fas fa-home"></i>
                    Inicio
                </button>
                <button class="nav-button" onclick="window.location.href='../compras/carrito.php'">
                    <i class="fas fa-shopping-cart"></i>
                    Mi carrito
                </button>
                <button class="nav-button" onclick="window.location.href='../compras/favorito.php'">
                    <i class="fas fa-heart"></i>
                    Mis favoritos
                </button>
                <button class="nav-button" onclick="window.location.href='../compras/mis_compras.php'">
                    <i class="fas fa-shopping-bag"></i>
                    Mis compras
                </button>
                <button class="nav-button">
                    <i class="fas fa-th"></i>
                    Categorías
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
                        <input class="bordear" type="text" placeholder="Busca tu producto aquí..." id="product-search">
                    </div>
                </div>

            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Hero Banner -->
            <div class="hero-banner">
                <div class="hero-content">
                    <h1 class="hero-title">¡Hola, <?php echo $nombreUsuario ?>!</h1>
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

            <section class="container mt-4 descuento">
                <div class="section-header">
                    <h2 class="section-title">Descuentos</h2>
                    <a href="#" class="section-link">mostrar todos</a>
                </div>

                <div class="products-scroll-container">
                    <div class="products-horizontal-list">
                        <?php foreach ($productos as $p): ?>
                            <div class="product-card-horizontal" onclick="openProductDetail(<?= $p['ID'] ?>)" style="cursor:pointer;">
                                <div class="product-image">
                                    <img src="../../public/img/products/<?= $p['foto'] ?>" alt="<?= $p['foto'] ?>">
                                    <button class="favorite-button" onclick="event.stopPropagation(); toggleFavoriteProduct(<?= $p['ID'] ?>, this)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="product-brand"><?= strtoupper($p['marca']) ?></div>
                                    <h6 class="product-name"><?= $p['nombre'] ?></h6>
                                    <div class="product-price">
                                        <?php if ($p['descuento'] > 0): ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'] * (1 - $p['descuento'] / 100), 0, ',', '.') ?></span>
                                            <span class="porcentaje">-<?= $p['descuento'] ?>%</span>
                                            <br><small class="text-muted text-decoration-line-through">$<?= number_format($p['precio_unitario'], 0, ',', '.') ?></small>
                                        <?php else: ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'], 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button class="add-button" id="btn-product-<?= $p['ID'] ?>" onclick="event.stopPropagation(); toggleCartProduct(<?= $p['ID'] ?>, this)">
                                        <span class="btn-text">Agregar 🛒</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Sección de Productos Nuevos -->
            <?php
            $sqlNuevos = "SELECT * FROM producto WHERE estado = 'Disponible' ORDER BY ID DESC LIMIT 12";
            $stmtNuevos = $conn->query($sqlNuevos);
            $productosNuevos = $stmtNuevos->fetch_all(MYSQLI_ASSOC);
            ?>
            <section class="container mt-5">
                <div class="section-header">
                    <h2 class="section-title">Productos Nuevos</h2>
                    <a href="#" class="section-link">mostrar todos</a>
                </div>

                <div class="products-scroll-container">
                    <div class="products-horizontal-list">
                        <?php foreach ($productosNuevos as $p): ?>
                            <div class="product-card-horizontal" onclick="openProductDetail(<?= $p['ID'] ?>)" style="cursor:pointer;">
                                <div class="product-image">
                                    <img src="../../public/img/products/<?= $p['foto'] ?>" alt="<?= $p['nombre'] ?>">
                                    <button class="favorite-button" onclick="event.stopPropagation(); toggleFavoriteProduct(<?= $p['ID'] ?>, this)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="product-brand"><?= strtoupper($p['marca']) ?></div>
                                    <h6 class="product-name"><?= $p['nombre'] ?></h6>
                                    <div class="product-price">
                                        <?php if ($p['descuento'] > 0): ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'] * (1 - $p['descuento'] / 100), 0, ',', '.') ?></span>
                                            <span class="porcentaje">-<?= $p['descuento'] ?>%</span>
                                            <br><small class="text-muted text-decoration-line-through">$<?= number_format($p['precio_unitario'], 0, ',', '.') ?></small>
                                        <?php else: ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'], 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button class="add-button" id="btn-product-<?= $p['ID'] ?>" onclick="event.stopPropagation(); toggleCartProduct(<?= $p['ID'] ?>, this)">
                                        <span class="btn-text">Agregar 🛒</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Sección de Productos Populares -->
            <?php
            $sqlPopulares = "SELECT p.*, COUNT(cp.producto_ID) as veces_comprado 
                           FROM producto p 
                           LEFT JOIN carrito_producto cp ON p.ID = cp.producto_ID 
                           WHERE p.estado = 'Disponible' 
                           GROUP BY p.ID 
                           ORDER BY veces_comprado DESC, p.ID ASC 
                           LIMIT 12";
            $stmtPopulares = $conn->query($sqlPopulares);
            $productosPopulares = $stmtPopulares->fetch_all(MYSQLI_ASSOC);
            ?>
            <section class="container mt-5">
                <div class="section-header">
                    <h2 class="section-title">Más Populares</h2>
                    <a href="#" class="section-link">mostrar todos</a>
                </div>

                <div class="products-scroll-container">
                    <div class="products-horizontal-list">
                        <?php foreach ($productosPopulares as $p): ?>
                            <div class="product-card-horizontal" onclick="openProductDetail(<?= $p['ID'] ?>)" style="cursor:pointer;">
                                <div class="product-image">
                                    <img src="../../public/img/products/<?= $p['foto'] ?>" alt="<?= $p['nombre'] ?>">
                                    <button class="favorite-button" onclick="event.stopPropagation(); toggleFavoriteProduct(<?= $p['ID'] ?>, this)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="product-brand"><?= strtoupper($p['marca']) ?></div>
                                    <h6 class="product-name"><?= $p['nombre'] ?></h6>
                                    <div class="product-price">
                                        <?php if ($p['descuento'] > 0): ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'] * (1 - $p['descuento'] / 100), 0, ',', '.') ?></span>
                                            <span class="porcentaje">-<?= $p['descuento'] ?>%</span>
                                            <br><small class="text-muted text-decoration-line-through">$<?= number_format($p['precio_unitario'], 0, ',', '.') ?></small>
                                        <?php else: ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'], 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button class="add-button" id="btn-product-<?= $p['ID'] ?>" onclick="event.stopPropagation(); toggleCartProduct(<?= $p['ID'] ?>, this)">
                                        <span class="btn-text">Agregar 🛒</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Sección de Todos los Productos -->
            <?php
            $sqlTodos = "SELECT * FROM producto WHERE estado = 'Disponible' ORDER BY nombre ASC LIMIT 15";
            $stmtTodos = $conn->query($sqlTodos);
            $todosProdutos = $stmtTodos->fetch_all(MYSQLI_ASSOC);
            ?>
            <section class="container mt-5 mb-5">
                <div class="section-header">
                    <h2 class="section-title">Todos los Productos</h2>
                    <a href="#" class="section-link">mostrar todos</a>
                </div>

                <div class="products-scroll-container">
                    <div class="products-horizontal-list">
                        <?php foreach ($todosProdutos as $p): ?>
                            <div class="product-card-horizontal" onclick="openProductDetail(<?= $p['ID'] ?>)" style="cursor:pointer; width: 150px;">
                                <div class="product-image">
                                    <img src="../../public/img/products/<?= $p['foto'] ?>" alt="<?= $p['nombre'] ?>">
                                    <button class="favorite-button" onclick="event.stopPropagation(); toggleFavoriteProduct(<?= $p['ID'] ?>, this)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="product-brand"><?= strtoupper($p['marca']) ?></div>
                                    <h6 class="product-name"><?= $p['nombre'] ?></h6>
                                    <div class="product-price">
                                        <?php if ($p['descuento'] > 0): ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'] * (1 - $p['descuento'] / 100), 0, ',', '.') ?></span>
                                            <span class="porcentaje">-<?= $p['descuento'] ?>%</span>
                                            <br><small class="text-muted text-decoration-line-through">$<?= number_format($p['precio_unitario'], 0, ',', '.') ?></small>
                                        <?php else: ?>
                                            <span class="fw-bold">$ <?= number_format($p['precio_unitario'], 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button class="add-button" id="btn-product-<?= $p['ID'] ?>" onclick="event.stopPropagation(); toggleCartProduct(<?= $p['ID'] ?>, this)">
                                        <span class="btn-text">Agregar 🛒</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

        </main>


        <?php require '../template/footer.php' ?>
    </div>




            <!-- React Aside Components Container -->
    <div id="aside-components-root"></div>

    <!-- Load React Components -->
    <script type="text/babel" src="../../public/js/components/CartAside.jsx"></script>
    <script type="text/babel" src="../../public/js/components/FavoritesAside.jsx"></script>
    <script type="text/babel" src="../../public/js/components/AsideManager.jsx"></script>

    <!-- Initialize React Components -->
    <script type="text/babel">
        // Wait for DOM to be fully loaded and all scripts to load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing React components...');
            
            // Wait a bit more to ensure all components are loaded
            setTimeout(() => {
                try {
                    // Check if components are available
                    if (typeof AsideManager === 'undefined') {
                        console.error('AsideManager component not found');
                        return;
                    }
                    if (typeof CartAside === 'undefined') {
                        console.error('CartAside component not found');
                        return;
                    }
                    if (typeof FavoritesAside === 'undefined') {
                        console.error('FavoritesAside component not found');
                        return;
                    }
                    
                    console.log('All components found, rendering AsideManager...');
                    
                    // Initialize the AsideManager component
                    const asideRoot = ReactDOM.createRoot(document.getElementById('aside-components-root'));
                    asideRoot.render(React.createElement(AsideManager));
                    
                    console.log('AsideManager rendered successfully');
                    
                    // Add test buttons for debugging
                    const testDiv = document.createElement('div');
                    testDiv.style.position = 'fixed';
                    testDiv.style.top = '10px';
                    testDiv.style.left = '10px';
                    testDiv.style.zIndex = '9999';
                    testDiv.style.backgroundColor = 'rgba(0,0,0,0.8)';
                    testDiv.style.color = 'white';
                    testDiv.style.padding = '10px';
                    testDiv.style.borderRadius = '5px';
                    testDiv.innerHTML = `
                        <div style="margin-bottom: 10px; font-size: 12px;">Debug Panel:</div>
                        <button onclick="window.testCartClick()" style="margin: 2px; padding: 5px 8px; font-size: 11px;">Test Cart</button>
                        <button onclick="window.testFavoritesClick()" style="margin: 2px; padding: 5px 8px; font-size: 11px;">Test Favorites</button>
                        <button onclick="window.closeAllAsides()" style="margin: 2px; padding: 5px 8px; font-size: 11px;">Close All</button>
                        <br>
                        <button onclick="checkButtons()" style="margin: 2px; padding: 5px 8px; font-size: 11px;">Check Buttons</button>
                    `;
                    document.body.appendChild(testDiv);
                    
                    // Add button checking function
                    window.checkButtons = () => {
                        const cartBtn = document.getElementById('cart-button');
                        const favBtn = document.getElementById('favorites-button');
                        console.log('Button check:', {
                            cartButton: cartBtn,
                            favoritesButton: favBtn,
                            cartButtonExists: !!cartBtn,
                            favoritesButtonExists: !!favBtn
                        });
                        
                        if (cartBtn) {
                            console.log('Cart button found, adding manual click test...');
                            cartBtn.style.border = '2px solid red';
                            setTimeout(() => cartBtn.style.border = '', 2000);
                        }
                        
                        if (favBtn) {
                            console.log('Favorites button found, adding manual click test...');
                            favBtn.style.border = '2px solid blue';
                            setTimeout(() => favBtn.style.border = '', 2000);
                        }
                    };
                    
                    // Also add fallback event listeners directly
                    setTimeout(() => {
                        const cartButton = document.getElementById('cart-button');
                        const favoritesButton = document.getElementById('favorites-button');
                        
                        if (cartButton && !cartButton.hasAttribute('data-listener-added')) {
                            console.log('Adding fallback cart listener...');
                            cartButton.addEventListener('click', (e) => {
                                e.preventDefault();
                                console.log('Fallback cart click triggered');
                                if (window.testCartClick) window.testCartClick();
                            });
                            cartButton.setAttribute('data-listener-added', 'true');
                        }
                        
                        if (favoritesButton && !favoritesButton.hasAttribute('data-listener-added')) {
                            console.log('Adding fallback favorites listener...');
                            favoritesButton.addEventListener('click', (e) => {
                                e.preventDefault();
                                console.log('Fallback favorites click triggered');
                                if (window.testFavoritesClick) window.testFavoritesClick();
                            });
                            favoritesButton.setAttribute('data-listener-added', 'true');
                        }
                    }, 1000);
                    
                } catch (error) {
                    console.error('Error initializing React components:', error);
                }
            }, 500);
        });


    </script>

    <script src="../../public/js/product-search.js"></script>
    <script src="../../controller/dashboard/home.js"></script>

    <!-- Toggle Cart Product Functionality -->
    <script>
        // Function to make AJAX request with proper session handling
        function makeAjaxRequest(url, data) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                resolve(response);
                            } catch (e) {
                                reject(new Error('Invalid JSON response'));
                            }
                        } else {
                            reject(new Error('HTTP Error: ' + xhr.status));
                        }
                    }
                };

                xhr.onerror = function() {
                    reject(new Error('Network error'));
                };

                xhr.send(data);
            });
        }

        // Function to toggle product in cart
        async function toggleCartProduct(productId, buttonElement) {
            const btnText = buttonElement.querySelector('.btn-text');
            const isInCart = btnText.textContent.includes('Agregado');

            // Disable button during request
            buttonElement.disabled = true;
            btnText.textContent = isInCart ? 'Eliminando...' : 'Agregando...';

            try {
                let response;
                if (isInCart) {
                    // Remove from cart
                    response = await makeAjaxRequest('../../quitarDelCarrito.php', `product_id=${productId}`);

                    if (response.success) {
                        btnText.textContent = 'Agregar 🛒';
                        buttonElement.style.backgroundColor = '#2ecb70';
                        buttonElement.style.color = 'white';
                    } else {
                        throw new Error(response.message || 'Error al eliminar del carrito');
                    }
                } else {
                    // Add to cart
                    response = await makeAjaxRequest('../../agregarAlCarrito.php', `product_id=${productId}&quantity=1`);

                    if (response.success) {
                        btnText.textContent = 'Agregado ✓';
                        buttonElement.style.backgroundColor = '#ffc107';
                        buttonElement.style.color = '#212529';
                    } else {
                        throw new Error(response.message || 'Error al agregar al carrito');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
                // Restore original state on error
                btnText.textContent = isInCart ? 'Agregado ✓' : 'Agregar 🛒';
                buttonElement.style.backgroundColor = isInCart ? '#ffc107' : '#2ecb70';
                buttonElement.style.color = isInCart ? '#212529' : 'white';
            } finally {
                buttonElement.disabled = false;
            }
        }

        // Initialize button states on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check cart status for all products and update button states
            checkCartStatus();
        });

        // Function to check which products are in cart
        async function checkCartStatus() {
            try {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '../../listarCarrito.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const data = JSON.parse(xhr.responseText);

                            if (data.success && data.data.length > 0) {
                                const cartProductIds = data.data.map(item => item.ID);

                                // Update button states for products in cart
                                cartProductIds.forEach(productId => {
                                    const button = document.getElementById(`btn-product-${productId}`);
                                    if (button) {
                                        const btnText = button.querySelector('.btn-text');
                                        btnText.textContent = 'Agregado ✓';
                                        button.style.backgroundColor = '#ffc107';
                                        button.style.color = '#212529';
                                    }
                                });
                            }
                        } catch (e) {
                            console.error('Error parsing cart status:', e);
                        }
                    }
                };

                xhr.send();
            } catch (error) {
                console.error('Error checking cart status:', error);
            }
        }

        // Function to toggle product in favorites
        async function toggleFavoriteProduct(productId, buttonElement) {
            const icon = buttonElement.querySelector('i');
            const isInFavorites = icon.classList.contains('fas');
            
            // Disable button during request
            buttonElement.disabled = true;
            
            try {
                let response;
                if (isInFavorites) {
                    // Remove from favorites
                    response = await makeAjaxRequest('../../quitarFavorito.php', `product_id=${productId}`);
                    
                    if (response.success) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        buttonElement.style.color = '#666';
                    } else {
                        throw new Error(response.message || 'Error al eliminar de favoritos');
                    }
                } else {
                    // Add to favorites
                    response = await makeAjaxRequest('../../agregarFavorito.php', `product_id=${productId}`);
                    
                    if (response.success) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        buttonElement.style.color = '#e74c3c';
                        alert('Producto agregado a favoritos');
                    } else {
                        throw new Error(response.message || 'Error al agregar a favoritos');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
            } finally {
                buttonElement.disabled = false;
            }
        }

        // Function to check which products are in favorites
        async function checkFavoritesStatus() {
            try {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '../../listarFavoritos.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const data = JSON.parse(xhr.responseText);

                            if (data.success && data.data.length > 0) {
                                const favoriteProductIds = data.data.map(item => item.ID);

                                // Update button states for products in favorites
                                favoriteProductIds.forEach(productId => {
                                    const favoriteButtons = document.querySelectorAll(`[onclick*="toggleFavoriteProduct(${productId}"]`);
                                    favoriteButtons.forEach(button => {
                                        const icon = button.querySelector('i');
                                        if (icon) {
                                            icon.classList.remove('far');
                                            icon.classList.add('fas');
                                            button.style.color = '#e74c3c';
                                        }
                                    });
                                });
                            }
                        } catch (e) {
                            console.error('Error parsing favorites status:', e);
                        }
                    }
                };

                xhr.send();
            } catch (error) {
                console.error('Error checking favorites status:', error);
            }
        }

        // Initialize favorites status on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check favorites status for all products and update button states
            setTimeout(() => {
                checkFavoritesStatus();
            }, 1000);
        });

        // Note: Modal functionality is handled by product-search.js
        // The openProductDetail function is already defined there
    </script>
</body>

</html>
