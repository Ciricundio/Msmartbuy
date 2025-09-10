<?php
session_start();
include_once '../../../config/conexion.php';

// Verificar autenticación y rol
if (!isset($_SESSION['ID']) || !isset($_SESSION['rol']) == 'admin') {
    echo '<div class="error">No autorizado</div>';
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="error">ID de producto inválido</div>';
    exit();
}

$producto_id = intval($_GET['id']);

// Obtener detalles completos del producto
$query = "SELECT 
    p.ID, 
    p.nombre, 
    p.marca, 
    p.precio_unitario, 
    p.descuento, 
    p.foto, 
    p.descripcion, 
    p.cantidad, 
    p.peso, 
    p.estado, 
    p.sku, 
    p.vistas, 
    c.categoria, 
    c.ID AS categoria_id,
    pr.ID AS proveedor_id,
    pr.nombre AS proveedor_nombre
FROM msmartbuy.producto AS p
LEFT JOIN msmartbuy.categoria AS c 
    ON p.categoria_ID = c.ID
LEFT JOIN msmartbuy.usuario AS pr 
    ON p.proveedor_ID = pr.ID 
    AND pr.rol = 'proveedor'
WHERE p.ID = ?

GROUP BY 
    p.ID, p.nombre, p.marca, p.precio_unitario, p.descuento, p.foto, p.descripcion, 
    p.cantidad, p.peso, p.estado, p.sku, p.vistas, 
    c.categoria, c.ID,
    pr.nombre, pr.ID
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $producto_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$producto = mysqli_fetch_assoc($result);

if ($producto) {
    // Calcular precio final con descuento
    $producto['precio_final'] = $producto['descuento'] ? 
        $producto['precio_unitario'] * (1 - $producto['descuento'] / 100) : 
        $producto['precio_unitario'];
}

if (!$producto) {
    echo '<div class="error">Producto no encontrado</div>';
    exit();
}

// Obtener categorías para el select
$query_categorias = "SELECT * FROM categoria ORDER BY categoria ASC";
$categorias = mysqli_query($conn, $query_categorias);

// Obtener proveedores para el select
$query_proveedores = "SELECT * FROM usuario WHERE rol = 'proveedor' ORDER BY nombre ASC";
$proveedores = mysqli_query($conn, $query_proveedores);
?>

<div class="producto-detalle">
    <div class="detalle-header">
        <div class="producto-imagen-grande">
            <?php if (!empty($producto['foto'])): ?>
                <img src="../../../public/img/products/<?php echo htmlspecialchars($producto['foto']);?>" 
                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <?php else: ?>
                <div class="sin-imagen-grande">
                    <i class="fas fa-image"></i>
                    <span>Sin imagen</span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="producto-info-principal">
            <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
            <p class="marca-grande"><?php echo htmlspecialchars($producto['marca']); ?></p>
            
            <div class="precios">
                <?php if ($producto['descuento'] > 0): ?>
                    <p class="precio-original">$<?php echo number_format($producto['precio_unitario'], 2); ?></p>
                    <p class="precio-grande">$<?php echo number_format($producto['precio_final'], 2); ?></p>
                    <span class="descuento-badge"><?php echo $producto['descuento']; ?>% OFF</span>
                <?php else: ?>
                    <p class="precio-grande">$<?php echo number_format($producto['precio_unitario'], 2); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="estado-badge estado-<?php echo strtolower($producto['estado']); ?>">
                <?php echo htmlspecialchars($producto['estado']); ?>
            </div>
            
            
        </div>
    </div>

    <div class="detalle-body">
        <div class="info-grid">
            <div class="info-item">
                <strong>SKU:</strong>
                <span><?php echo htmlspecialchars($producto['sku']); ?></span>
            </div>
            <div class="info-item">
                <strong>Cantidad en stock:</strong>
                <span><?php echo $producto['cantidad']; ?> unidades</span>
            </div>
            <div class="info-item">
                <strong>Peso:</strong>
                <span><?php echo !empty($producto['peso']) ? htmlspecialchars($producto['peso']) : 'No especificado'; ?></span>
            </div>
            <div class="info-item">
                <strong>Categoría:</strong>
                <span><?php echo htmlspecialchars($producto['categoria']); ?></span>
            </div>
            <div class="info-item">
                <strong>Proveedor:</strong>
                <span><?php echo htmlspecialchars($producto['proveedor_nombre']); ?></span>
            </div>
            <div class="info-item">
                <strong>Vistas:</strong>
                <span><?php echo number_format($producto['vistas']); ?></span>
            </div>
            <?php if ($producto['descuento'] > 0): ?>
            <div class="info-item">
                <strong>Descuento:</strong>
                <span><?php echo $producto['descuento']; ?>%</span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($producto['descripcion'])): ?>
            <div class="descripcion">
                <strong>Descripción:</strong>
                <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal-actions">
        <button type="button" class="btn btn-primary" onclick="activarModoEdicion()">
            <i class="fas fa-edit"></i> Editar
        </button>
        <!-- <button type="button" class="btn btn-danger" onclick="confirmarEliminacion(<?php echo $producto['ID']; ?>)">
            <i class="fas fa-trash"></i> Eliminar
        </button> -->
        <button type="button" class="btn btn-outline" onclick="cerrarModalDetalle()">
            <i class="fas fa-times"></i> Cerrar
        </button>
    </div>
</div>

<!-- Formulario de edición (inicialmente oculto) -->
<div id="formulario-edicion" style="display: none;">
    <form id="form-editar-producto" onsubmit="guardarCambios(event)">
        <input type="hidden" name="producto_id" value="<?php echo $producto['ID']; ?>">
        
        <div class="form-row grid">
            <div class="form-group">
                <label for="edit_nombre">Nombre del producto</label>
                <input type="text" id="edit_nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="edit_marca">Marca</label>
                <input type="text" id="edit_marca" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>
            </div>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="edit_precio">Precio Unitario</label>
                <input type="number" id="edit_precio" name="precio_unitario" value="<?php echo $producto['precio_unitario']; ?>" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="edit_descuento">Descuento (%)</label>
                <input type="number" id="edit_descuento" name="descuento" value="<?php echo $producto['descuento']; ?>" step="0.01" min="0" max="100">
            </div>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="edit_cantidad">Cantidad</label>
                <input type="number" id="edit_cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="edit_peso">Peso</label>
                <input type="text" id="edit_peso" name="peso" value="<?php echo htmlspecialchars($producto['peso']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="edit_descripcion">Descripción</label>
            <textarea id="edit_descripcion" name="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="edit_sku">SKU</label>
                <input type="text" id="edit_sku" name="sku" value="<?php echo htmlspecialchars($producto['sku']); ?>" required>
            </div>
            <div class="form-group">
                <label for="edit_estado">Estado</label>
                <select id="edit_estado" name="estado" required>
                    <option value="Disponible" <?php echo $producto['estado'] == 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                    <option value="Agotado" <?php echo $producto['estado'] == 'Agotado' ? 'selected' : ''; ?>>Agotado</option>
                    <option value="Descontinuado" <?php echo $producto['estado'] == 'Descontinuado' ? 'selected' : ''; ?>>Descontinuado</option>
                </select>
            </div>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="edit_categoria">Categoría</label>
                <select id="edit_categoria" name="categoria_ID" required>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                        <option value="<?php echo $cat['ID']; ?>" <?php echo $cat['ID'] == $producto['categoria_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['categoria']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_proveedor">Proveedor</label>
                <select id="edit_proveedor" name="proveedor_ID" required>
                    <?php while ($prov = mysqli_fetch_assoc($proveedores)): ?>
                        <option value="<?php echo $prov['ID']; ?>" <?php echo $prov['ID'] == $producto['proveedor_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($prov['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <button type="button" class="btn btn-outline" onclick="cancelarEdicion()">
                <i class="fas fa-times"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<style>
    .producto-detalle {
        padding: 0;
    }

    .detalle-header {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .producto-imagen-grande {
        width: 250px;
        height: 250px;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .producto-imagen-grande img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sin-imagen-grande {
        text-align: center;
        color: #6c757d;
    }

    .sin-imagen-grande i {
        font-size: 3rem;
        display: block;
        margin-bottom: 10px;
    }

    .producto-info-principal h2 {
        margin: 0 0 10px 0;
        color: #333;
    }

    .marca-grande {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 15px;
    }

    .precios {
        margin-bottom: 15px;
    }

    .precio-original {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .precio-grande {
        font-size: 2rem;
        font-weight: bold;
        color: #28a745;
        margin: 0;
    }

    .descuento-badge {
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: bold;
        margin-left: 10px;
    }

    .calificacion {
        margin: 15px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .estrellas {
        color: #ffc107;
        font-size: 1.2rem;
    }

    .promedio {
        font-weight: bold;
        color: #495057;
    }

    .total-resenas {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .estado-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 6px;
    }

    .info-item strong {
        display: block;
        color: #495057;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .info-item span {
        color: #333;
        font-size: 1rem;
    }

    .descripcion {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .descripcion strong {
        display: block;
        margin-bottom: 10px;
        color: #495057;
    }

    .descripcion p {
        color: #333;
        line-height: 1.6;
        margin: 0;
    }

    .modal-actions {
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .loading, .error {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .error {
        color: #dc3545;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .detalle-header {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .producto-imagen-grande {
            margin: 0 auto;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-actions {
            flex-direction: column;
        }
    }
</style>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>