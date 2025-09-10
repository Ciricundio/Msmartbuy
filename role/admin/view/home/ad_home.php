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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
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
          <a href="?opcion=1" class="inicio">Inicio</a>
        </li>
        <li>
          <a href="?opcion=2" class="categoriaPlus">+ Categoría</a>
        </li>
        <li>
          <a href="?opcion=3" class="producto">+ Productos</a>
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
      </div>

      <?php 
        if (isset($_GET['opcion']) && $_GET['opcion'] == 2) {
            // Modal para Agregar Categoría -->
            include '../form/agregarCategoria.php';
        } elseif (isset($_GET['opcion']) && $_GET['opcion'] == 3) {
            // Modal para Agregar Producto -->
            include '../form/gestionProducto.php';
        } elseif (isset($_GET['opcion']) && $_GET['opcion'] == 1) {
            // Contenedor de Categorías
            include 'mostrarCategoria.php';
        }else {
            // Por defecto, mostrar las categorías
            include 'mostrarCategoria.php';
        }
      ?>
    </main>

    <script src="../../public/js/inventariooo.js"></script>

    <script>
    function activarModoEdicion() {
        document.querySelector('.producto-detalle').style.display = 'none';
        document.getElementById('formulario-edicion').style.display = 'block';
    }

    function cancelarEdicion() {
        document.querySelector('.producto-detalle').style.display = 'block';
        document.getElementById('formulario-edicion').style.display = 'none';
    }

    function guardarCambios(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        
        fetch('../../controller/editar_producto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('Producto actualizado correctamente', 'success');
                cerrarModalDetalle();
                // Recargar la lista de productos
                location.reload();
            } else {
                mostrarNotificacion(data.message || 'Error al actualizar el producto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error de conexión', 'error');
        });
    }

    /*function confirmarEliminacion(productoId) {
        if (confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
            eliminarProducto(productoId);
        }
    }

    function eliminarProducto(productoId) {
        fetch('../../controller/eliminar_producto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                producto_id: productoId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('Producto eliminado correctamente', 'success');
                cerrarModalDetalle();
                // Recargar la lista de productos
                location.reload();
            } else {
                mostrarNotificacion(data.message || 'Error al eliminar el producto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error de conexión', 'error');
        });
    } */

    function mostrarNotificacion(mensaje, tipo = 'info') {
        const noti = document.createElement('div');
        noti.className = `notificacion ${tipo}`;
        noti.textContent = mensaje;
        
        // Estilos básicos para la notificación
        noti.style.position = 'fixed';
        noti.style.top = '20px';
        noti.style.right = '20px';
        noti.style.padding = '15px 20px';
        noti.style.borderRadius = '5px';
        noti.style.color = 'white';
        noti.style.zIndex = '10000';
        noti.style.opacity = '0';
        noti.style.transition = 'opacity 0.3s ease';
        
        if (tipo === 'success') {
            noti.style.backgroundColor = '#28a745';
        } else if (tipo === 'error') {
            noti.style.backgroundColor = '#dc3545';
        } else {
            noti.style.backgroundColor = '#17a2b8';
        }
        
        document.body.appendChild(noti);
        
        // Mostrar con animación
        setTimeout(() => noti.style.opacity = '1', 100);
        
        // Ocultar después de 3 segundos
        setTimeout(() => {
            noti.style.opacity = '0';
            setTimeout(() => noti.remove(), 300);
        }, 3000);
    }
</script>
  </body>
</html>