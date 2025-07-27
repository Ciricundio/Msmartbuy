// Variables globales
let currentView = "categorias"
let currentCategoryId = null

// Inicialización cuando el DOM está listo
document.addEventListener("DOMContentLoaded", () => {
  initializeEventListeners()
  loadCategorias()
})

// Configurar todos los event listeners
function initializeEventListeners() {
  // Botones principales
  document.getElementById("btnNuevaCategoria").addEventListener("click", () => openModal("modalCategoria"))
  document.getElementById("btnNuevoProducto").addEventListener("click", () => openModal("modalProducto"))
  document.getElementById("btnVolverCategorias").addEventListener("click", showCategorias)

  // Formularios
  document.getElementById("formCategoria").addEventListener("submit", handleCategoriaSubmit)
  document.getElementById("formProducto").addEventListener("submit", handleProductoSubmit)

  // Cerrar modales
  document.querySelectorAll(".modal-close, [data-modal]").forEach((element) => {
    element.addEventListener("click", function (e) {
      if (e.target === this) {
        const modalId = this.getAttribute("data-modal") || this.closest(".modal-overlay").id
        closeModal(modalId)
      }
    })
  })

  // Cerrar modal al hacer clic fuera
  document.querySelectorAll(".modal-overlay").forEach((overlay) => {
    overlay.addEventListener("click", function (e) {
      if (e.target === this) {
        closeModal(this.id)
      }
    })
  })

  // Navegación del sidebar
  document.querySelectorAll(".nav-link").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()
      const section = this.getAttribute("data-section")
      handleNavigation(section)
    })
  })
}

// Manejar navegación del sidebar
function handleNavigation(section) {
  // Actualizar estado activo
  document.querySelectorAll(".nav-link").forEach((link) => link.classList.remove("active"))
  document.querySelector(`[data-section="${section}"]`).classList.add("active")

  // Por ahora solo manejamos inventario
  if (section === "inventario") {
    showCategorias()
  }
}

// Cargar categorías desde el servidor
async function loadCategorias() {
  try {
    showLoading(true)
    // Recargar la página para obtener las categorías actualizadas
    // En una implementación más avanzada, esto sería una llamada AJAX
    location.reload()
  } catch (error) {
    console.error("Error al cargar categorías:", error)
    showNotification("Error al cargar las categorías", "error")
  } finally {
    showLoading(false)
  }
}

// Mostrar vista de categorías
function showCategorias() {
  currentView = "categorias"
  document.getElementById("categoriasGrid").style.display = "grid"
  document.getElementById("productosContainer").style.display = "none"

  // Reconfigurar event listeners para las tarjetas de categoría
  document.querySelectorAll(".categoria-card").forEach((card) => {
    card.addEventListener("click", function () {
      const categoriaId = this.getAttribute("data-categoria-id")
      loadProductosCategoria(categoriaId)
    })
  })
}

// Cargar productos de una categoría específica
async function loadProductosCategoria(categoriaId) {
  try {
    showLoading(true)

    const response = await fetch(`../../controller/obtener_productos_categoria.php?categoria_id=${categoriaId}`)
    const data = await response.json()

    if (data.success) {
      currentCategoryId = categoriaId
      currentView = "productos"

      // Actualizar título
      document.getElementById("tituloCategoria").textContent = data.categoria

      // Renderizar productos
      renderProductos(data.productos)

      // Mostrar vista de productos
      document.getElementById("categoriasGrid").style.display = "none"
      document.getElementById("productosContainer").style.display = "block"
    } else {
      showNotification(data.message || "Error al cargar productos", "error")
    }
  } catch (error) {
    console.error("Error al cargar productos:", error)
    showNotification("Error de conexión al cargar productos", "error")
  } finally {
    showLoading(false)
  }
}

// Renderizar productos en el grid
function renderProductos(productos) {
  const productosGrid = document.getElementById("productosGrid")

  if (productos.length === 0) {
    productosGrid.innerHTML = `
            <div class="no-productos">
                <p>No hay productos en esta categoría</p>
                <button class="btn btn-primary" onclick="openModal('modalProducto')">
                    <i class="fas fa-plus"></i> Agregar Primer Producto
                </button>
            </div>
        `
    return
  }

  productosGrid.innerHTML = productos
    .map(
      (producto) => `
        <div class="producto-card">
            <div class="producto-header">
                <img src="${producto.foto}" alt="${producto.nombre}" class="producto-imagen" 
                     onerror="this.src='../../public/img/default-product.jpg'">
                <div class="producto-info">
                    <h4>${escapeHtml(producto.nombre)}</h4>
                    <div class="marca">${escapeHtml(producto.marca)}</div>
                    <div class="precio">$${producto.precio_unitario}</div>
                </div>
            </div>
            <div class="producto-details">
                <div class="producto-cantidad">
                    <i class="fas fa-boxes"></i> ${producto.cantidad} unidades
                </div>
                <span class="producto-estado estado-${producto.estado.toLowerCase().replace(" ", "-")}">
                    ${producto.estado}
                </span>
            </div>
            ${
              producto.proveedor_nombre
                ? `
                <div class="producto-proveedor">
                    <small><i class="fas fa-truck"></i> ${escapeHtml(producto.proveedor_nombre)}</small>
                </div>
            `
                : ""
            }
        </div>
    `,
    )
    .join("")
}

// Manejar envío del formulario de categoría
async function handleCategoriaSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)

  try {
    showLoading(true)

    const response = await fetch("../../controller/agregar_categoria.php", {
      method: "POST",
      body: formData,
    })

    const data = await response.json()

    if (data.success) {
      showNotification("Categoría agregada exitosamente", "success")
      closeModal("modalCategoria")
      e.target.reset()

      // Agregar nueva categoría al DOM
      addCategoriaToGrid(data.categoria_id, data.categoria_nombre)
    } else {
      showNotification(data.message || "Error al agregar categoría", "error")
    }
  } catch (error) {
    console.error("Error al agregar categoría:", error)
    showNotification("Error de conexión", "error")
  } finally {
    showLoading(false)
  }
}

// Manejar envío del formulario de producto
async function handleProductoSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)

  // Validaciones del lado del cliente
  if (!validateProductForm(formData)) {
    return
  }

  try {
    showLoading(true)

    const response = await fetch("../../controller/agregar_producto.php", {
      method: "POST",
      body: formData,
    })

    const data = await response.json()

    if (data.success) {
      showNotification("Producto agregado exitosamente", "success")
      closeModal("modalProducto")
      e.target.reset()

      // Si estamos viendo productos de una categoría, recargar
      if (currentView === "productos" && currentCategoryId) {
        loadProductosCategoria(currentCategoryId)
      }
    } else {
      showNotification(data.message || "Error al agregar producto", "error")
    }
  } catch (error) {
    console.error("Error al agregar producto:", error)
    showNotification("Error de conexión", "error")
  } finally {
    showLoading(false)
  }
}

// Validar formulario de producto
function validateProductForm(formData) {
  const nombre = formData.get("nombre").trim()
  const marca = formData.get("marca").trim()
  const cantidad = Number.parseInt(formData.get("cantidad"))
  const precio = Number.parseFloat(formData.get("precio_unitario"))
  const categoria = Number.parseInt(formData.get("categoria_ID"))
  const proveedor = Number.parseInt(formData.get("proveedor_ID"))

  if (!nombre || !marca) {
    showNotification("Nombre y marca son obligatorios", "error")
    return false
  }

  if (cantidad < 0) {
    showNotification("La cantidad no puede ser negativa", "error")
    return false
  }

  if (precio < 0) {
    showNotification("El precio no puede ser negativo", "error")
    return false
  }

  if (!categoria || !proveedor) {
    showNotification("Debe seleccionar categoría y proveedor", "error")
    return false
  }

  // Validar archivo de imagen si se seleccionó
  const foto = formData.get("foto")
  if (foto && foto.size > 0) {
    const allowedTypes = ["image/jpeg", "image/png", "image/gif"]
    const maxSize = 5 * 1024 * 1024 // 5MB

    if (!allowedTypes.includes(foto.type)) {
      showNotification("Tipo de archivo no permitido. Use JPG, PNG o GIF", "error")
      return false
    }

    if (foto.size > maxSize) {
      showNotification("El archivo es demasiado grande. Máximo 5MB", "error")
      return false
    }
  }

  return true
}

// Agregar nueva categoría al grid
function addCategoriaToGrid(categoriaId, categoriaNombre) {
  const categoriasGrid = document.getElementById("categoriasGrid")

  const nuevaCategoria = document.createElement("div")
  nuevaCategoria.className = "categoria-card"
  nuevaCategoria.setAttribute("data-categoria-id", categoriaId)
  nuevaCategoria.innerHTML = `
        <div class="categoria-background" style="background-image: url('../../public/img/default-category.jpg');"></div>
        <div class="categoria-overlay">
            <h3>${escapeHtml(categoriaNombre)}</h3>
        </div>
    `

  // Agregar event listener
  nuevaCategoria.addEventListener("click", () => {
    loadProductosCategoria(categoriaId)
  })

  categoriasGrid.appendChild(nuevaCategoria)
}

// Funciones de utilidad para modales
function openModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.add("active")
    document.body.style.overflow = "hidden"
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.remove("active")
    document.body.style.overflow = "auto"

    // Limpiar formularios
    const form = modal.querySelector("form")
    if (form) {
      form.reset()
    }
  }
}

// Mostrar/ocultar loading spinner
function showLoading(show) {
  const spinner = document.getElementById("loadingSpinner")
  if (spinner) {
    spinner.classList.toggle("active", show)
  }
}

// Sistema de notificaciones
function showNotification(message, type = "info") {
  // Crear elemento de notificación
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${escapeHtml(message)}</span>
        </div>
        <button class="notification-close">&times;</button>
    `

  // Agregar estilos si no existen
  if (!document.querySelector("#notification-styles")) {
    const styles = document.createElement("style")
    styles.id = "notification-styles"
    styles.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 8px;
                padding: 1rem;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 4000;
                display: flex;
                align-items: center;
                gap: 1rem;
                min-width: 300px;
                animation: slideInRight 0.3s ease-out;
            }
            .notification-success { border-left: 4px solid #28a745; }
            .notification-error { border-left: 4px solid #dc3545; }
            .notification-info { border-left: 4px solid #17a2b8; }
            .notification-warning { border-left: 4px solid #ffc107; }
            .notification-content { flex: 1; display: flex; align-items: center; gap: 0.5rem; }
            .notification-close { 
                background: none; border: none; font-size: 1.2rem; 
                cursor: pointer; color: #999; 
            }
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `
    document.head.appendChild(styles)
  }

  // Agregar al DOM
  document.body.appendChild(notification)

  // Cerrar al hacer clic
  notification.querySelector(".notification-close").addEventListener("click", () => {
    notification.remove()
  })

  // Auto-cerrar después de 5 segundos
  setTimeout(() => {
    if (notification.parentNode) {
      notification.remove()
    }
  }, 5000)
}

// Obtener icono para notificación
function getNotificationIcon(type) {
  const icons = {
    success: "check-circle",
    error: "exclamation-circle",
    warning: "exclamation-triangle",
    info: "info-circle",
  }
  return icons[type] || "info-circle"
}

// Escapar HTML para prevenir XSS
function escapeHtml(text) {
  const map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  }
  return text.replace(/[&<>"']/g, (m) => map[m])
}

// Funciones de utilidad adicionales
function formatCurrency(amount) {
  return new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
  }).format(amount)
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString("es-CO")
}

// Manejo de errores globales
window.addEventListener("error", (e) => {
  console.error("Error global:", e.error)
  showNotification("Ha ocurrido un error inesperado", "error")
})

// Manejo de promesas rechazadas
window.addEventListener("unhandledrejection", (e) => {
  console.error("Promesa rechazada:", e.reason)
  showNotification("Error de conexión", "error")
})
