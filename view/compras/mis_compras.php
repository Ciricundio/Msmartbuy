<?php
session_start();
require '../../config/conexion.php';

// Validar que exista la sesión obligatoria
if (!isset($_SESSION['ID'])) {
    header('Location: ../../view/auth/login.php');
    exit;
}

$idUsuario = $_SESSION['ID'];

// Obtener nombre del usuario
$sqlUsuario = "SELECT * FROM usuario WHERE ID = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("i", $idUsuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows === 0) {
    die("Error: Usuario no encontrado.");
}

$usuario = $resultUsuario->fetch_assoc();
$nombreUsuario = $usuario['nombre'];
$apellidoUsuario = $usuario['apellido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras - Msmartbuy</title>
    <link rel="icon" href="../../public/img/Icono/Icon_cnt.svg">
    <link rel="stylesheet" href="../../public/css/home.css">
    <!-- Incluir Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/mis_compras.css">
</head>
<body>
    <div class="purchases-container">
        <a href="../home/home.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Volver al Inicio
        </a>
        
        <h1 style="margin-bottom: 30px; color: #333;">
            <i class="fas fa-shopping-bag" style="margin-right: 10px;"></i>
            Mis Compras
        </h1>
        
        <div id="purchases-content">
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Cargando tus compras...</p>
            </div>
        </div>
    </div>

    <script>
        // Formatear precio
        function formatPrice(price) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            }).format(price);
        }

        // Formatear fecha
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-CO', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Cargar compras
        async function loadPurchases() {
            try {
                const response = await fetch('../../controller/pago/listarCompras.php', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();
                const container = document.getElementById('purchases-content');

                if (data.success) {
                    if (data.data.length === 0) {
                        container.innerHTML = `
                            <div class="empty-state">
                                <i class="fas fa-shopping-bag"></i>
                                <h3>No tienes compras aún</h3>
                                <p>Cuando realices tu primera compra, aparecerá aquí.</p>
                                <a href="../home/home.php" class="btn btn-primary" style="margin-top: 20px;">
                                    Comenzar a Comprar
                                </a>
                            </div>
                        `;
                    } else {
                        let html = '';
                        data.data.forEach(purchase => {
                            html += `
                                <div class="purchase-card">
                                    <div class="purchase-header">
                                        <div class="purchase-info">
                                            <div>
                                                <div class="purchase-date">Compra del ${formatDate(purchase.fecha)}</div>
                                                <div style="font-size: 14px; color: #666; margin-top: 4px;">
                                                    ${purchase.total_productos} producto${purchase.total_productos > 1 ? 's' : ''}
                                                </div>
                                            </div>
                                            <div class="purchase-total">${formatPrice(purchase.total)}</div>
                                        </div>
                                        <div class="purchase-status status-${purchase.estado}">
                                            ${purchase.estado}
                                        </div>
                                    </div>
                                    <div class="purchase-items">
                            `;
                            
                            purchase.detalles.forEach(item => {
                                html += `
                                    <div class="purchase-item">
                                        <div class="item-image">
                                            <img src="../../public/img/products/${item.foto || 'default.jpg'}" 
                                                 alt="${item.nombre}"
                                                 onerror="this.src='../../public/img/products/default.jpg'">
                                        </div>
                                        <div class="item-details">
                                            <div class="item-name">${item.nombre}</div>
                                            <div class="item-quantity">Cantidad: ${item.cantidad_producto}</div>
                                        </div>
                                        <div class="item-price">${formatPrice(item.subtotal)}</div>
                                    </div>
                                `;
                            });
                            
                            html += `
                                    </div>
                                </div>
                            `;
                        });
                        
                        container.innerHTML = html;
                    }
                } else {
                    throw new Error(data.message || 'Error al cargar las compras');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('purchases-content').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                        <h3>Error al cargar las compras</h3>
                        <p>${error.message}</p>
                        <button onclick="loadPurchases()" class="btn btn-primary" style="margin-top: 20px;">
                            Reintentar
                        </button>
                    </div>
                `;
            }
        }

        // Cargar compras al cargar la página
        document.addEventListener('DOMContentLoaded', loadPurchases);
    </script>
</body>
</html>
