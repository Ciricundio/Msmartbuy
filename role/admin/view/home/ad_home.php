<?php
// ==========================  Configuración  =============================
require_once '../../../../config/conexion.php'; // Asumiendo que esto define $conn

// CORRECCIÓN: Usar $conn en lugar de $conn para consistencia
$queryCat = "SELECT * FROM categoria ORDER BY categoria";
$categorias = mysqli_query($conn, $queryCat);

$queryProv = "SELECT ID, nombre FROM usuario WHERE rol = 'proveedor'";
$proveedores = mysqli_query($conn, $queryProv);

// CORRECCIÓN: Rol 'admin' para consistencia
$queryAdmin = "SELECT nombre, apellido FROM usuario WHERE rol = 'Admin'";
$admin = mysqli_query($conn, $queryAdmin);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Msmartbuy - Inventario</title>
  <link rel="icon" href="../../public/img/Icono/Icon_adm.svg">
  <link rel="stylesheet" href="../../public/css/categoria.css"> <!-- Mantener categoria.css para estilos específicos de categorías -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Añadir Font Awesome para iconos -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
>
</head>

<body class="container">

  <nav>
    <ul>
      <li>
        <img src="../../public/img/Icono/Icon_adm.svg" alt="Logo" class="logo" width="40" height="40">
      </li>
      <li>
        <strong>Msmartbuy</strong>
      </li>
    </ul>
    <ul>
      <li>
        <a href="#" class="secondary">Inicio</a>
      </li>
      <li>
        <details class="dropdown">
          <summary>
            Cuenta
          </summary>
          <ul dir="rtl">
            <li>
              <span class="user-name">
                <?php $ad = mysqli_fetch_assoc($admin);
                echo $ad['nombre'] . ' ' . $ad['apellido']; ?>
              </span>
            </li>
            <li>
              <a href="../../../../controller/auth/logout.php" class="logout">Cerrar sesión</a>
            </li>
          </ul>
        </details>
      </li>
    </ul>
  </nav>

  <main class="main-content">
    <div class="content-header">
      <h1>Bienvenido, <span class="user-name">
          <?php echo $ad['nombre']; ?>
        </span>!</h1>
      <div class="header-actions">
        <button class="btn btn-primary" id="btnNuevaCategoria"><i class="fas fa-plus"></i> Nueva Categoría</button>
        <button class="btn btn-secondary" id="btnNuevoProducto"><i class="fas fa-plus"></i> Nuevo Producto</button>
      </div>
    </div>

    <!-- Contenedor de Categorías -->
    <section id="categoriasGrid" class="categorias-grid">
      <?php if ($categorias && mysqli_num_rows($categorias) > 0): ?>
        <?php mysqli_data_seek($categorias, 0); // Resetear puntero para el bucle ?>
        <?php while ($row = mysqli_fetch_assoc($categorias)): ?>
          <div class="categoria-card" data-categoria-id="<?php echo $row['ID']; ?>">
            <div class="categoria-background" style="background-image: url('../../public/img/categorias/<?php echo strtolower($row['imagen']); ?>.jpg');"></div>
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
  </main>

  <!-- Modal para Agregar Categoría -->
  <div id="modalCategoria" class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h3>Agregar Categoría</h3>
        <button class="modal-close" data-modal="modalCategoria">&times;</button>
      </div>
      <form action="../../controller/agregar_categoria.php" id="formCategoria" method="post">
        <div class="form-group">
          <label for="categoria_nombre">Nombre de la categoría</label>
          <input type="text" id="categoria_nombre" name="categoria" placeholder="Ej: Lácteos, Frutas, Limpieza" required>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Agregar</button>
          <button type="button" class="btn btn-outline" data-modal="modalCategoria"><i class="fas fa-times"></i> Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal para Agregar Producto -->
  <div id="modalProducto" class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h3>Agregar Producto</h3>
        <button class="modal-close" data-modal="modalProducto">&times;</button>
      </div>
      <?php if ($proveedores && mysqli_num_rows($proveedores) > 0): ?>
        <form action="../../controller/agregar_producto.php" method="post" id="formProducto" enctype="multipart/form-data" >
          <div class="form-row">
            <div class="form-group">
              <label for="nombre_producto">Nombre del producto</label>
              <input type="text" id="nombre_producto" name="nombre" placeholder="Ej: Leche Entera" required>
            </div>
            <div class="form-group">
              <label for="marca_producto">Marca</label>
              <input type="text" id="marca_producto" name="marca" placeholder="Ej: Alpina" required>
            </div>
          </div>
          <div class="form-row">
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
          <div class="form-group">
            <label for="sku_producto">SKU</label>
            <input type="text" id="sku_producto" name="sku" placeholder="EJEMPLO454" require></input>
          </div>
          <div class="form-row">
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
          <div class="form-row">
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
          <div class="form-group">
            <label for="foto_producto">Imagen del Producto</label>
            <input type="file" id="foto_producto" name="foto" accept="image/*">
            <small>Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB.</small>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Agregar Producto</button>
            <button type="button" class="btn btn-outline" data-modal="modalProducto"><i class="fas fa-times"></i> Cancelar</button>
          </div>
        </form>
      <?php else: ?>
        <p>No existen proveedores registrados. Por favor registra proveedores antes de agregar productos.</p>
        <div class="form-actions">
          <button type="button" class="btn btn-outline" data-modal="modalProducto">Cerrar</button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="../../public/js/inventario.js"></script>
</body>

</html>
