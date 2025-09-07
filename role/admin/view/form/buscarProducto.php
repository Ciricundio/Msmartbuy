<?php

// Consulta de productos con categoría y proveedor (desde usuario con rol=proveedor)
$query_productos = "SELECT p.*, c.categoria, u.nombre AS proveedor_nombre
                   FROM producto p 
                   LEFT JOIN categoria c ON p.categoria_ID = c.ID 
                   LEFT JOIN usuario u ON p.proveedor_ID = u.ID AND u.rol = 'proveedor'
                   ORDER BY p.nombre ASC";
$productos = mysqli_query($conn, $query_productos);
?>

<style>
    .search-container {
        margin-bottom: 20px;
    }

    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        max-height: 60vh;
        overflow-y: auto;
        padding: 10px 0;
    }

    .producto-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .producto-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: #007bff;
    }

    .producto-imagen {
        width: 100%;
        height: 150px;
        margin-bottom: 15px;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
    }

    .producto-imagen img {
        height: 100%;
        object-fit: cover;
    }

    .sin-imagen {
        text-align: center;
        color: #6c757d;
    }

    .sin-imagen i {
        font-size: 2rem;
        display: block;
        margin-bottom: 5px;
    }

    .producto-info h4 {
        margin: 0 0 8px 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .producto-info .marca {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .producto-info .precio {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 10px;
    }

    .producto-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        gap: 10px;
    }

    .categoria {
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        color: #495057;
    }

    .estado {
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .estado-disponible {
        background: #d4edda;
        color: #155724;
    }

    .estado-agotado {
        background: #f8d7da;
        color: #721c24;
    }

    .estado-descontinuado {
        background: #fff3cd;
        color: #856404;
    }

    .cantidad,
    .sku,
    .proveedor {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }

    .no-productos {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .no-productos i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }

    #modalDetalleProducto {
        position: absolute;
        top: 50%;
        left: 50%;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .background {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);        
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-large {
        max-width: 800px;
        width: 90%;
        height: 90%;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #666;
    }

    .btn-close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }
</style>

<div class="container">
    <!-- Buscador -->
    <div class="search-container">
        <div class="form-group">
            <label for="buscar_producto">Buscar producto</label>
            <input type="text" id="buscar_producto" placeholder="Buscar por nombre, marca o SKU..." onkeyup="filtrarProductos()">
        </div>
    </div>

    <!-- Grid de productos -->
    <div class="productos-grid" id="productos-container">
        <?php if ($productos && mysqli_num_rows($productos) > 0): ?>
            <?php while ($producto = mysqli_fetch_assoc($productos)): ?>
                <div class="producto-card"
                    data-nombre="<?php echo strtolower($producto['nombre']); ?>"
                    data-marca="<?php echo strtolower($producto['marca']); ?>"
                    data-sku="<?php echo strtolower($producto['sku']); ?>"
                    onclick="abrirModalDetalle(<?php echo $producto['ID']; ?>)">

                    <div class="producto-imagen">
                        <?php if (!empty($producto['foto'])): ?>
                            <img src="../../../../public/img/products/<?php echo htmlspecialchars($producto['foto']); ?>"
                                alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <?php else: ?>
                            <div class="sin-imagen">
                                <i class="fas fa-image"></i>
                                <span>Sin imagen</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="producto-info">
                        <h4><?php echo htmlspecialchars($producto['nombre']); ?></h4>
                        <p class="marca"><?php echo htmlspecialchars($producto['marca']); ?></p>
                        <p class="precio">$<?php echo number_format($producto['precio_unitario'], 2); ?></p>
                        <div class="producto-meta">
                            <span class="categoria"><?php echo htmlspecialchars($producto['categoria']); ?></span>
                            <span class="estado estado-<?php echo strtolower($producto['estado']); ?>">
                                <?php echo htmlspecialchars($producto['estado']); ?>
                            </span>
                        </div>
                        <p class="cantidad">Cantidad: <?php echo (int)$producto['cantidad']; ?></p>
                        <p class="sku">SKU: <?php echo htmlspecialchars($producto['sku']); ?></p>
                        <p class="proveedor">Proveedor: <?php echo htmlspecialchars($producto['proveedor_nombre'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-productos">
                <i class="fas fa-box-open"></i>
                <p>No hay productos registrados</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal de detalles del producto -->
    <div id="modalDetalleProducto" class="modal-overlay" style="display: none;">
        <div class="background">
            <div class="modal modal-large">
                <div class="modal-header">
                    <h3>Detalles del Producto</h3>
                    <button type="button" class="btn-close" onclick="cerrarModalDetalle()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="contenido-detalle">
                    <!-- Aquí se carga el detalle del producto vía AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function filtrarProductos() {
        const filtro = document.getElementById('buscar_producto').value.toLowerCase();
        const productos = document.querySelectorAll('.producto-card');

        productos.forEach(producto => {
            const nombre = producto.dataset.nombre;
            const marca = producto.dataset.marca;
            const sku = producto.dataset.sku;

            if (nombre.includes(filtro) || marca.includes(filtro) || sku.includes(filtro)) {
                producto.style.display = 'block';
            } else {
                producto.style.display = 'none';
            }
        });
    }

    function abrirModalDetalle(productoId) {
        const modal = document.getElementById('modalDetalleProducto');
        const contenido = document.getElementById('contenido-detalle');

        contenido.innerHTML = '<div class="loading">Cargando...</div>';
        modal.style.display = 'flex';

        fetch('../../controller/obtener_producto_detalle.php?id=' + productoId)
            .then(response => response.text())
            .then(data => {
                contenido.innerHTML = data;
            })
            .catch(error => {
                contenido.innerHTML = '<div class="error">Error al cargar los detalles del producto</div>';
                console.error('Error:', error);
            });

    }

    function cerrarModalDetalle() {
        document.getElementById('modalDetalleProducto').style.display = 'none';
    }

    document.getElementById('modalDetalleProducto').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalDetalle();
        }
    });
</script>