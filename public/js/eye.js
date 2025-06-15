document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    // Verifica si el navegador ya muestra el botón de mostrar contraseña
    const hasNativeReveal = passwordInput.type === "password" && 'showPasswordToggle' in HTMLInputElement.prototype;
    
    // Si no lo tiene, activamos el botón personalizado
    if (!hasNativeReveal && togglePassword) {
        togglePassword.addEventListener('click', function () {
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<span class="material-symbols-outlined">visibility</span>' : '<span class="material-symbols-outlined">visibility_off</span>'; // Cambia ícono según estado
        });

    } else {
        // Oculta el icono si el navegador ya lo tiene incorporado
        togglePassword.style.display = 'none';
    }
});

