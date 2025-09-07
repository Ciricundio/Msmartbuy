document.addEventListener("DOMContentLoaded", () => {
  // Manejar los botones de favoritos
  const favoriteButtons = document.querySelectorAll(".favorite-button")

  // Manejar los botones de navegación
  const navButtons = document.querySelectorAll(".nav-button")

  navButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remover la clase active de todos los botones
      navButtons.forEach((btn) => {
        if (btn !== this && !btn.querySelector(".fa-sign-out-alt")) {
          btn.classList.remove("active")
        }
      })

      // Agregar la clase active al botón clickeado
      // No aplicar a botón de cerrar sesión
      if (!this.querySelector(".fa-sign-out-alt")) {
        this.classList.add("active")
      }
    })
  })

  // Los botones de agregar al carrito ahora son manejados por toggleCartProduct()
  // en home.php, así que removemos esta funcionalidad duplicada
})
