document.addEventListener("DOMContentLoaded", () => {
  // Manejar los botones de favoritos
  const favoriteButtons = document.querySelectorAll(".favorite-button")

  favoriteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      this.classList.toggle("active")

      // Cambiar el ícono
      const icon = this.querySelector("i")
      if (this.classList.contains("active")) {
        icon.classList.remove("far")
        icon.classList.add("fas")
      } else {
        icon.classList.remove("fas")
        icon.classList.add("far")
      }
    })
  })

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

  // Manejar los botones de agregar al carrito
  const addButtons = document.querySelectorAll(".add-button")
  const card = document.querySelectorAll(".product-card")


  addButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // Aquí se podría implementar la lógica para agregar al carrito
      addButtons.classList.add("orange");
      alert("Producto agregado al carrito")
    })
  })
})
