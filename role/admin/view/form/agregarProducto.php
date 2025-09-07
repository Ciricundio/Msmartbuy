<?php if ($proveedores && mysqli_num_rows($proveedores) > 0): ?>
    <form action="../../controller/agregar_producto.php" method="post" id="formProducto" enctype="multipart/form-data">

        <div class="form-row grid">
            <div class="form-group">
                <label for="nombre_producto">Nombre del producto</label>
                <input type="text" id="nombre_producto" name="nombre" placeholder="Ej: Leche Entera" required>
            </div>
            <div class="form-group">
                <label for="marca_producto">Marca</label>
                <input type="text" id="marca_producto" name="marca" placeholder="Ej: Alpina" required>
            </div>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="cantidad_producto">Cantidad</label>
                <input type="number" id="cantidad_producto" name="cantidad" placeholder="Ej: 100" min="0" required>
            </div>
            <div class="form-group">
                <label for="precio_producto">Precio Unitario</label>
                <input type="number" id="precio_producto" name="precio_unitario" placeholder="Ej: 3500.50" step="0.01" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion_producto">Descripción</label>
            <textarea id="descripcion_producto" name="descripcion" placeholder="Descripción detallada del producto"></textarea>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="peso_producto">Peso (opcional)</label>
                <input type="text" id="peso_producto" name="peso" placeholder="Ej: 1 Litro, 500g">
            </div>
            <div class="form-group">
                <label for="estado_producto">Estado</label>
                <select id="estado_producto" name="estado" required>
                    <option value="Disponible">Disponible</option>
                    <option value="Agotado">Agotado</option>
                    <option value="Descontinuado">Descontinuado</option>
                </select>
            </div>
        </div>

        <div class="form-row grid">
            <div class="form-group">
                <label for="categoria_ID">Categoría</label>
                <select id="categoria_ID" name="categoria_ID" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <?php
                    mysqli_data_seek($categorias, 0); // Resetear puntero
                    while ($cat = mysqli_fetch_assoc($categorias)) {
                        echo '<option value="' . $cat['ID'] . '">' . htmlspecialchars($cat['categoria']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="proveedor_ID">Proveedor</label>
                <select id="proveedor_ID" name="proveedor_ID" required>
                    <option value="" disabled selected>Seleccione un proveedor</option>
                    <?php
                    mysqli_data_seek($proveedores, 0); // Resetear puntero
                    while ($prov = mysqli_fetch_assoc($proveedores)) {
                        echo '<option value="' . $prov['ID'] . '">' . htmlspecialchars($prov['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row grid">
            <div class="form-group">
                <label for="foto_producto">Imagen del Producto</label>
                <input type="file" id="foto_producto" name="foto" accept="image/*">
                <small>Formatos permitidos: JPG, PNG. Tamaño máximo: 5MB.</small>
            </div>
            <div class="form-group">
                <label for="sku_producto">SKU</label>
                <input type="text" id="sku_producto" name="sku" placeholder="EJEMPLO454" require></input>
            </div>
        </div>

        <div class="form-actions grid">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Agregar Producto</button>
            <button type="button" class="btn btn-outline" data-modal="modalProducto"><i class="fas fa-times"></i> Cancelar</button>
        </div>

    </form>
<?php else: ?>
    <p>No existen proveedores registrados. Por favor registra proveedores antes de agregar productos.</p>
    <div class="form-actions">
        <button type="button" class="btn btn-outline" data-modal="modalProducto" onclick="window.location.href = 'ad_home.php?opcion=2';">Cerrar</button>
    </div>
<?php endif; ?>