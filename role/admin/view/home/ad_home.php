<?php
// ==========================  Configuración  =============================
require_once '../../../../config/conexion.php';

$queryCat = "SELECT ID, categoria FROM categoria ORDER BY categoria";
$categorias = mysqli_query($conn, $queryCat);

$queryProv = "SELECT ID, nombre FROM usuario WHERE rol = 'proveedor'";
$proveedores = mysqli_query($conn, $queryProv);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Msmartbuy - Inventario</title>
  <link rel="stylesheet" href="../../public/css/msmartbuy.css">
</head>
<body>
  <aside class="sidebar">
    <img src="../../public/img/Icono/Icon_adm.svg" alt="Logo" class="logo">
    <nav class="menu">
      <a href="#" class="active">Inicio</a>
      <a href="#">Autenticación</a>
      <a href="#">Inventario</a>
      <a href="#">Reportes <span class="dot"></span></a>
      <a href="#">UserAdmin <span class="dot"></span></a>
    </nav>
    <div class="user-box">
      <span class="user-icon">CM</span>
      <span class="user-name">Ciro Muñoz</span>
      <a href="../../../logout.php" class="logout">Cerrar sesión</a>
    </div>
  </aside>

  <main class="main-content">
    <div class="header">
      <h1>Bienvenido, Luisx!</h1>
      <p>En tus manos queda la gestión estratégica de nuestro minimarket.</p>
    </div>

    <section class="inventario-controls">
      <button onclick="abrirModalCategoria()">+ Nueva Categoría</button>
      <button onclick="abrirModalProducto()">+ Nuevo Producto</button>
    </section>

    <section id="categorias" class="categorias-grid">
      <?php if ($categorias && mysqli_num_rows($categorias) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($categorias)): ?>
          <div class="categoria-card" onclick="cargarProductos(<?php echo $row['ID']; ?>, '<?php echo $row['categoria']; ?>')">
            <div class="categoria-background" style="background-image: url('../../public/img/categorias/<?php echo strtolower($row['categoria']); ?>.jpg');"></div>
            <div class="categoria-overlay">
              <h3><?php echo htmlspecialchars($row['categoria']); ?></h3>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <script>
          window.onload = () => alert('No existen categorías registradas. Agrega una nueva categoría para empezar.');
        </script>
      <?php endif; ?>
    </section>

    <section id="productos" class="productos-grid hidden"></section>
  </main>

  <div id="modalCategoria" class="modal hidden">
    <div class="modal-content">
      <h3>Agregar Categoría</h3>
      <form id="formCategoria" action="../../../controller/inventario/agregar_categoria.php" method="POST">
        <input type="text" name="categoria" placeholder="Nombre de la categoría" required>
        <button type="submit">Agregar</button>
        <button type="button" onclick="cerrarModalCategoria()">Cancelar</button>
      </form>
    </div>
  </div>

  <div id="modalProducto" class="modal hidden">
    <div class="modal-content">
      <h3>Agregar Producto</h3>
      <?php if ($proveedores && mysqli_num_rows($proveedores) > 0): ?>
      <form id="formProducto" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="marca" placeholder="Marca" required>
        <input type="text" name="cantidad" placeholder="Cantidad" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="precio_unitario" placeholder="Precio unitario" required>
        <input type="text" name="peso" placeholder="Peso (opcional)">
        <select name="estado" required>
          <option value="Disponible">Disponible</option>
          <option value="Agotado">Agotado</option>
        </select>
        <input type="file" name="foto" accept="image/*">
        <select name="categoria_ID" id="categoriaSelect" required>
          <?php
            mysqli_data_seek($categorias, 0);
            while($cat = mysqli_fetch_assoc($categorias)) {
              echo '<option value="'.$cat['ID'].'">'.$cat['categoria'].'</option>';
            }
          ?>
        </select>
        <select name="proveedor_ID" required>
          <?php while($prov = mysqli_fetch_assoc($proveedores)) {
            echo '<option value="'.$prov['ID'].'">'.$prov['nombre'].'</option>';
          } ?>
        </select>
        <button type="submit">Agregar</button>
        <button type="button" onclick="cerrarModalProducto()">Cancelar</button>
      </form>
      <?php else: ?>
        <p>No existen proveedores registrados. Por favor registra proveedores antes de agregar productos.</p>
        <button type="button" onclick="cerrarModalProducto()">Cerrar</button>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function abrirModalCategoria() {
      document.getElementById('modalCategoria').classList.remove('hidden');
    }
    function cerrarModalCategoria() {
      document.getElementById('modalCategoria').classList.add('hidden');
    }
    function abrirModalProducto() {
      document.getElementById('modalProducto').classList.remove('hidden');
    }
    function cerrarModalProducto() {
      document.getElementById('modalProducto').classList.add('hidden');
    }
    function cargarProductos(categoriaID, nombreCategoria) {
      const contenedor = document.getElementById('productos');
      contenedor.classList.remove('hidden');
      contenedor.innerHTML = `<p style='padding:1rem'>Cargando productos de <strong>${nombreCategoria}</strong>...</p>`;
      // Aquí podrías agregar una petición fetch/ajax si quieres cargar desde PHP
    }
  </script>
  <script src="../../public/js/inventario.js"></script>
</body>
</html>
