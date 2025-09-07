<section id="categoriasGrid" class="categorias-grid">
<?php if ($categorias && mysqli_num_rows($categorias) > 0): ?>
    <?php mysqli_data_seek($categorias, 0); // Resetear puntero para el bucle ?>
    <?php while ($row = mysqli_fetch_assoc($categorias)): ?>
    <div class="categoria-card" data-categoria-id="<?php echo $row['ID']; ?>">
        <div class="categoria-background" style="background-image: url('../../public/img/categorias/<?php echo strtolower($row['imagen']);?>.jpg');"></div>
        <div class="categoria-overlay">
        <h3><?php echo htmlspecialchars($row['categoria']); ?></h3>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <!-- El JS manejará este caso, pero se puede dejar un placeholder -->
    <div class="no-categorias">
    <p>No hay categorías disponibles. Agrega una nueva categoría para empezar.</p>
    </div>
<?php endif; ?>
</section>

<!-- Contenedor de Productos (inicialmente oculto) -->
<section id="productosContainer" class="productos-container" style="display: none;">
    <div class="productos-header">
        <button class="btn btn-outline" id="btnVolverCategorias"><i class="fas fa-arrow-left"></i> Volver a Categorías</button>
        <h2 id="tituloCategoria"></h2>
    </div>
    <div id="productosGrid" class="productos-grid">
        <!-- Los productos se cargarán aquí dinámicamente con JS -->
    </div>
</section>