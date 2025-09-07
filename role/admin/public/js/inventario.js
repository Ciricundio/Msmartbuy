// Variables globales
let currentView = "categorias"
let currentCategoryId = null

// Inicialización cuando el DOM está listo
document.addEventListener("DOMContentLoaded", () => {
  initializeEventListeners()
  // Configurar los listeners para las tarjetas de categoría que ya están en el HTML
  setupCategoriaCardListeners()
  // Si quieres que las categorías se recarguen dinámicamente al cargar la página, descomenta la siguiente línea:
  loadCategorias();
})

// Configurar todos los event listeners
function initializeEventListeners() {
  // Botones principales - Verificar que existen antes de agregar listeners
  const btnNuevaCategoria = document.getElementById("btnNuevaCategoria")
  if (btnNuevaCategoria) {
    btnNuevaCategoria.addEventListener("click", () => openModal("modalCategoria"))
  }
  
  const btnNuevoProducto = document.getElementById("btnNuevoProducto")
  if (btnNuevoProducto) {
    btnNuevoProducto.addEventListener("click", () => openModal("modalProducto"))
  }
  
  const btnVolverCategorias = document.getElementById("btnVolverCategorias")
  if (btnVolverCategorias) {
    btnVolverCategorias.addEventListener("click", showCategorias)
  }

  // Formularios - Verificar que existen
  const formCategoria = document.getElementById("formCategoria")
  if (formCategoria) {
    formCategoria.addEventListener("submit", handleCategoriaSubmit)
  }
  
  const formProducto = document.getElementById("formProducto")
  if (formProducto) {
    formProducto.addEventListener("submit", handleProductoSubmit)
  }

  // Cerrar modales
  document.querySelectorAll(".modal-close, .modal-overlay").forEach((element) => {
    element.addEventListener("click", function (e) {
      // Asegurarse de que el clic sea en el overlay o en el botón de cierre
      if (e.target === this || e.target.classList.contains('modal-close')) {
        const modalId = this.getAttribute("data-modal") || this.closest(".modal-overlay").id
        closeModal(modalId)
      }
    })
  })

  // Navegación del sidebar (si se implementa un sidebar real)
  document.querySelectorAll(".nav-link").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()
      const section = this.getAttribute("data-section")
      handleNavigation(section)
    })
  })
}

// Configurar listeners para las tarjetas de categoría existentes en el DOM
function setupCategoriaCardListeners() {
  document.querySelectorAll(".categoria-card").forEach((card) => {
    card.addEventListener("click", function () {
      const categoriaId = this.getAttribute("data-categoria-id")
      loadProductosCategoria(categoriaId)
    })
  })
}

// Manejar navegación del sidebar
function handleNavigation(section) {
  // Actualizar estado activo
  document.querySelectorAll(".nav-link").forEach((link) => link.classList.remove("active"))
  const navLink = document.querySelector(`[data-section="${section}"]`)
  if (navLink) {
    navLink.classList.add("active")
  }

  // Por ahora solo manejamos inventario
  if (section === "inventario") {
    showCategorias()
  }
}

// Cargar categorías desde el servidor (para recargar dinámicamente, por ejemplo, después de agregar una nueva)
async function loadCategorias() {
  try {
    showLoading(true)
    // CORRECCIÓN: Usar el nuevo controlador para obtener todas las categorías
    const response = await fetch("../../controller/obtener_categoria.php") 
    const data = await response.json()
    if (data.success && Array.isArray(data.categorias)) {
      renderCategorias(data.categorias)
    } else {
      showNotification(data.message || "No se pudieron cargar las categorías", "error")
    }
  } catch (error) {
    console.error("Error al cargar categorías:", error)
    showNotification("Error al cargar las categorías", "error")
  } finally {
    showLoading(false)
  }
}

// Renderizar categorías en el grid (si se cargan dinámicamente)
function renderCategorias(categorias) {
  const categoriasGrid = document.getElementById("categoriasGrid")
  if (!categoriasGrid) return

  if (categorias.length === 0) {
    categoriasGrid.innerHTML = `<div class="no-categorias"><p>No hay categorías disponibles</p></div>`
    return
  }

  categoriasGrid.innerHTML = categorias
    .map(
      (cat) => `
        <div class="categoria-card" data-categoria-id="${cat.ID}">
          <div class="categoria-background" style="background-image: url('../../public/img/categorias/${escapeHtml(cat.categoria.toLowerCase())}.jpg');"></div>
          <div class="categoria-overlay">
            <h3>${escapeHtml(cat.categoria)}</h3>
          </div>
        </div>
      `
    )
    .join("")

  // Reconfigurar event listeners para las tarjetas de categoría recién renderizadas
  setupCategoriaCardListeners()
}


// Mostrar vista de categorías
function showCategorias() {
  currentView = "categorias"
  const categoriasGrid = document.getElementById("categoriasGrid")
  const productosContainer = document.getElementById("productosContainer")
  
  if (categoriasGrid) {
    categoriasGrid.style.display = "grid"
  }
  if (productosContainer) {
    productosContainer.style.display = "none"
  }
}

// Cargar productos de una categoría específica
async function loadProductosCategoria(categoriaId) {
  try {
    showLoading(true)

    // CORRECCIÓN: La URL ya es correcta para obtener productos de una categoría
    const response = await fetch(`../../controller/obtener_productos_categoria.php?categoria_id=${categoriaId}`)
    const data = await response.json()

    if (data.success) {
      currentCategoryId = categoriaId
      currentView = "productos"

      // Actualizar título
      const tituloCategoria = document.getElementById("tituloCategoria")
      if (tituloCategoria) {
        tituloCategoria.textContent = data.categoria
      }

      // Renderizar productos
      renderProductos(data.productos)

      // Mostrar vista de productos
      const categoriasGrid = document.getElementById("categoriasGrid")
      const productosContainer = document.getElementById("productosContainer")
      
      if (categoriasGrid) {
        categoriasGrid.style.display = "none"
      }
      if (productosContainer) {
        productosContainer.style.display = "block"
      }
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
  if (!productosGrid) return

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

    // La URL del controlador de agregar categoría ya es correcta
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
      // Si no estamos en una vista de productos, recargar categorías para que la nueva categoría aparezca
      else {
        loadCategorias(); // Recargar todas las categorías para que la nueva aparezca
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

  if (isNaN(cantidad) || cantidad < 0) { // Añadir isNaN check
    showNotification("La cantidad debe ser un número positivo", "error")
    return false
  }

  if (isNaN(precio) || precio < 0) { // Añadir isNaN check
    showNotification("El precio debe ser un número positivo", "error")
    return false
  }

  if (!categoria || categoria <= 0) { // Asegurar que no sea 0 o NaN
    showNotification("Debe seleccionar una categoría válida", "error")
    return false
  }
  if (!proveedor || proveedor <= 0) { // Asegurar que no sea 0 o NaN
    showNotification("Debe seleccionar un proveedor válido", "error")
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
  if (!categoriasGrid) return

  // Remover el mensaje de "no hay categorías" si existe
  const noCategoriasDiv = categoriasGrid.querySelector(".no-categorias");
  if (noCategoriasDiv) {
    noCategoriasDiv.remove();
  }

  const nuevaCategoria = document.createElement("div")
  nuevaCategoria.className = "categoria-card"
  nuevaCategoria.setAttribute("data-categoria-id", categoriaId)
  nuevaCategoria.innerHTML = `
        <div class="categoria-background" style="background-image: url('../../public/img/categorias/${escapeHtml(categoriaNombre.toLowerCase())}.jpg');"></div>
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
/* window.addEventListener("error", (e) => {
  console.error("Error global:", e.error)
  showNotification("Ha ocurrido un error inesperado", "error")
}) */

// Manejo de promesas rechazadas
window.addEventListener("unhandledrejection", (e) => {
  console.error("Promesa rechazada:", e.reason)
  showNotification("Error de conexión", "error")
})