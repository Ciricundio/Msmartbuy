
<div id="modalCategoria" class="modal-overlay" style="margin: 0 10%;">
    <div class="modal">
        <div class="modal-header">
            <h3>Agregar Categoría</h3>
        </div>

        <form action="../../controller/agregar_categoria.php" id="formCategoria" method="post">
        <div class="form-group">
            <label for="categoria_nombre">Nombre de la categoría</label>
            <input type="text" id="categoria_nombre" name="categoria" placeholder="Ej: Lácteos, Frutas, Limpieza" required>
        </div>
        <div class="form-actions grid">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Agregar</button>
            <button type="button" class="btn btn-outline" data-modal="modalCategoria" onclick="window.location.href = 'ad_home.php?opcion=2';"><i class="fas fa-times"></i> Cancelar</button>
        </div>
        </form>
    </div>
</div>