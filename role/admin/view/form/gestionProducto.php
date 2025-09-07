<div id="modalProducto" class="modal-overlay" style="margin: 0 10%;">
    <div class="modal">
        <div class="modal-header grid">
            <h3>Gestión de productos</h3>
            <nav class="">
                <ul>
                    <li>
                        <a href="?opcion=3&gestion=1" class="secondary">Agregar</a>
                    </li>
                    <li>
                        <a href="?opcion=3&gestion=2" class="secondary">Buscar</a>
                    </li>
                </ul>
            </nav>
        </div>

        <?php
        if (isset($_GET['gestion']) && $_GET['gestion'] == 2) {
            include 'buscarProducto.php';

        } elseif (isset($_GET['gestion']) && $_GET['gestion'] == 1) {
            include 'agregarProducto.php';
        } else {
            include 'agregarProducto.php';

        }
        ?>

    </div>
</div>