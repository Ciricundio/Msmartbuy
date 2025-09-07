<?php
session_start();
require_once '../../config/conexion.php';

// Obtener favoritos
$userId = isset($_SESSION['ID']) ? $_SESSION['ID'] : (isset($_GET['user_id']) ? intval($_GET['user_id']) : 0);
$favorites = [];
$error = null;

if ($userId <= 0) {
    $error = "Usuario no autenticado";
} else {
    try {
        $sql = "SELECT p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, c.categoria
                FROM favorito_producto fp
                JOIN favorito f ON fp.favorito_ID = f.ID
                JOIN producto p ON fp.producto_ID = p.ID
                JOIN categoria c ON p.categoria_ID = c.ID
                WHERE f.usuario_ID = ? AND p.estado = 'Disponible'
                ORDER BY p.nombre";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $row['precio_final'] = $row['descuento'] ? 
                $row['precio_unitario'] * (1 - $row['descuento'] / 100) : 
                $row['precio_unitario'];
            $favorites[] = $row;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos Favoritos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .stats {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            color: white;
            text-align: center;
        }

        .error-message {
            background: #ff4757;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out;
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 60px 20px;
            text-align: center;
            color: white;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: white;
            position: relative;
            overflow: hidden;
            display: flex;              /* activa flexbox */
            justify-content: center;
        }

        .product-image img {
            justify-self: center;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }



        .product-image .placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
            font-size: 3rem;
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ff4757;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
        }

        .favorite-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .favorite-btn:hover {
            background: white;
            transform: scale(1.1);
        }

        .favorite-btn i {
            color: #ff4757;
            font-size: 1.2rem;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .product-brand {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .product-description {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .price-original {
            color: #999;
            text-decoration: line-through;
            font-size: 0.9rem;
        }

        .price-final {
            color: #27ae60;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .btn-primary {
            background: #667eea;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #5a67d8;
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #666;
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e9ecef;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .search-filter {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .filter-select {
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            min-width: 150px;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .search-filter {
                flex-direction: column;
            }
            
            .search-input, .filter-select {
                width: 100%;
                min-width: unset;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-heart"></i>
                Mis Productos Favoritos
            </h1>
            <p>Descubre y gestiona tus productos favoritos</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                Error: <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (empty($favorites)): ?>
            <div class="empty-state">
                <i class="fas fa-heart-broken"></i>
                <h2>No tienes productos favoritos</h2>
                <p>¡Comienza a agregar productos a tu lista de favoritos para verlos aquí!</p>
                <br>
                <a href="../home/home.php" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    Ver Productos
                </a>
            </div>
        <?php else: ?>
            <div class="stats">
                <h3><i class="fas fa-chart-bar"></i> Estadísticas de Favoritos</h3>
                <p>Tienes <strong><?php echo count($favorites); ?></strong> productos en tu lista de favoritos</p>
            </div>

            <div class="search-filter">
                <input type="text" id="searchInput" placeholder="Buscar productos..." class="search-input">
                <select id="categoryFilter" class="filter-select">
                    <option value="">Todas las categorías</option>
                    <?php
                    $categories = array_unique(array_column($favorites, 'categoria'));
                    foreach ($categories as $category):
                    ?>
                        <option value="<?php echo htmlspecialchars($category); ?>">
                            <?php echo htmlspecialchars($category); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button onclick="clearFilters()" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Limpiar
                </button>
            </div>

            <div class="products-grid" id="productsGrid">
                <?php foreach ($favorites as $product): ?>
                    <div class="product-card" data-category="<?php echo htmlspecialchars($product['categoria']); ?>" data-name="<?php echo strtolower(htmlspecialchars($product['nombre'] . ' ' . $product['marca'])); ?>">
                        <div class="product-image">
                            <?php if ($product['foto']): ?>
                                <img src="../../public/img/products/<?php echo htmlspecialchars($product['foto']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>">
                            <?php else: ?>
                                <div class="placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['descuento'] > 0): ?>
                                <div class="discount-badge">
                                    -<?php echo $product['descuento']; ?>%
                                </div>
                            <?php endif; ?>
                            
                            <button class="favorite-btn" onclick="removeFromFavorites(<?php echo $product['ID']; ?>, this)" title="Quitar de favoritos">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-category">
                                <?php echo htmlspecialchars($product['categoria']); ?>
                            </div>
                            
                            <div class="product-name">
                                <?php echo htmlspecialchars($product['nombre']); ?>
                            </div>
                            
                            <div class="product-brand">
                                <?php echo htmlspecialchars($product['marca']); ?>
                            </div>
                            
                            <?php if ($product['descripcion']): ?>
                                <div class="product-description">
                                    <?php echo htmlspecialchars($product['descripcion']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="price-section">
                                <?php if ($product['descuento'] > 0): ?>
                                    <span class="price-original">
                                        $<?php echo number_format($product['precio_unitario'], 2); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="price-final">
                                    $<?php echo number_format($product['precio_final'], 2); ?>
                                </span>
                            </div>
                            
                            <div class="product-actions">
                                <button id="btn-product-<?php echo $product['ID']; ?>" onclick="toggleCartProduct(<?php echo $product['ID']; ?>, this)" class="btn btn-primary">
                                    <span class="btn-text">
                                        <i class="fas fa-shopping-cart"></i>
                                        Agregar al Carrito
                                    </span>
                                </button>
                                <a href="../producto/detalle.php?id=<?php echo $product['ID']; ?>" class="btn btn-secondary">
                                    <i class="fas fa-eye"></i>
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Funciones AJAX para carrito y favoritos -->
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

        // Función para filtrar productos
        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productName = card.getAttribute('data-name');
                const productCategory = card.getAttribute('data-category');
                
                const matchesSearch = productName.includes(searchTerm);
                const matchesCategory = !categoryFilter || productCategory === categoryFilter;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            updateStats();
        }

        // Función para limpiar filtros
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            filterProducts();
        }

        // Función para remover de favoritos con AJAX real
        async function removeFromFavorites(productId, buttonElement) {
            if (confirm('¿Estás seguro de que quieres quitar este producto de tus favoritos?')) {
                // Disable button during request
                buttonElement.disabled = true;
                
                try {
                    const response = await makeAjaxRequest('../../quitarFavorito.php', `product_id=${productId}`);
                    
                    if (response.success) {
                        // Find and remove the product card
                        const card = buttonElement.closest('.product-card');
                        if (card) {
                            card.style.animation = 'fadeOutUp 0.5s ease forwards';
                            setTimeout(() => {
                                card.remove();
                                updateStats();
                                
                                // Check if no favorites left
                                const remainingCards = document.querySelectorAll('.product-card').length;
                                if (remainingCards === 0) {
                                    location.reload(); // Reload to show empty state
                                }
                            }, 500);
                        }
                    } else {
                        throw new Error(response.message || 'Error al eliminar de favoritos');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message);
                } finally {
                    buttonElement.disabled = false;
                }
            }
        }

        // Function to toggle product in cart
        async function toggleCartProduct(productId, buttonElement) {
            const btnText = buttonElement.querySelector('.btn-text') || buttonElement;
            const isInCart = btnText.textContent.includes('Agregado') || btnText.textContent.includes('✓');

            // Disable button during request
            buttonElement.disabled = true;
            const originalText = btnText.textContent;
            btnText.textContent = isInCart ? 'Eliminando...' : 'Agregando...';

            try {
                let response;
                if (isInCart) {
                    // Remove from cart
                    response = await makeAjaxRequest('../../quitarDelCarrito.php', `product_id=${productId}`);

                    if (response.success) {
                        btnText.innerHTML = '<i class="fas fa-shopping-cart"></i> Agregar al Carrito';
                        buttonElement.style.backgroundColor = '#667eea';
                        buttonElement.style.color = 'white';
                    } else {
                        throw new Error(response.message || 'Error al eliminar del carrito');
                    }
                } else {
                    // Add to cart
                    response = await makeAjaxRequest('../../agregarAlCarrito.php', `product_id=${productId}&quantity=1`);

                    if (response.success) {
                        btnText.innerHTML = '<i class="fas fa-check"></i> Agregado al Carrito';
                        buttonElement.style.backgroundColor = '#27ae60';
                        buttonElement.style.color = 'white';
                    } else {
                        throw new Error(response.message || 'Error al agregar al carrito');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
                // Restore original state on error
                btnText.textContent = originalText;
            } finally {
                buttonElement.disabled = false;
            }
        }

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
                                        const btnText = button.querySelector('.btn-text') || button;
                                        btnText.innerHTML = '<i class="fas fa-check"></i> Agregado al Carrito';
                                        button.style.backgroundColor = '#27ae60';
                                        button.style.color = 'white';
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

        // Función para actualizar estadísticas
        function updateStats() {
            const visibleCards = document.querySelectorAll('.product-card:not([style*="display: none"])').length;
            const totalCards = document.querySelectorAll('.product-card').length;
            const statsElement = document.querySelector('.stats p');
            if (statsElement) {
                if (visibleCards === totalCards) {
                    statsElement.innerHTML = `Tienes <strong>${totalCards}</strong> productos en tu lista de favoritos`;
                } else {
                    statsElement.innerHTML = `Mostrando <strong>${visibleCards}</strong> de <strong>${totalCards}</strong> productos favoritos`;
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check cart status for all products and update button states
            checkCartStatus();
            
            // Event listeners
            document.getElementById('searchInput')?.addEventListener('input', filterProducts);
            document.getElementById('categoryFilter')?.addEventListener('change', filterProducts);
        });

        // Animación CSS adicional para fadeOut
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOutUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-30px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>