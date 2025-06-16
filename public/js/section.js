document.addEventListener('DOMContentLoaded', () => {
  const opciones = document.querySelectorAll('.cuadro');
  const boton = document.getElementById('btn');

  const colores = {
      cliente: 'var(--verde)',
      proveedor: 'var(--morado)',
      repartidor: 'var(--rojo)',
      masculino: 'var(--masculino)',
      femenino: 'var(--femenino)',
      otro: 'var(--otro)'
  };

  const colorHex = {
      cliente: '#28a745',
      proveedor: '#6f42c1',
      repartidor: '#dc3545',
      masculino: '#3498DB',
      femenino: '#F24E77',
      otro: '#9B59B6'
  };

  const inputHidden = document.createElement('input');
  inputHidden.type = 'hidden';

  // Detectar si es rol o genero
  const opcionesRoles = ['cliente', 'proveedor', 'repartidor'];
  const opcionesGenero = ['femenino', 'masculino', 'otro'];

  const tipoSeleccion = Array.from(opciones).some(op => opcionesRoles.includes(op.dataset.role))
      ? 'rol'
      : 'genero';

  inputHidden.name = tipoSeleccion;
  document.querySelector('form').appendChild(inputHidden);

  // Variable para almacenar la selección actual
  let seleccionActual = '';

  opciones.forEach(opcion => {
      opcion.addEventListener('click', () => {
          opciones.forEach(o => {
              o.classList.remove('activo');
              o.querySelector('h2').style.color = '#000';
              const contenedor = o.querySelector('.c0');
              contenedor.style.boxShadow = '0 0 0px 2px #eee';
              const check = contenedor.querySelector('.check');
              if (check) check.remove();
          });

          opcion.classList.add('activo');
          const valor = opcion.dataset.role;
          seleccionActual = valor; // Guarda la selección actual
          const colorVar = colores[valor];
          const colorHexValue = colorHex[valor];

          opcion.querySelector('h2').style.color = colorVar;
          boton.style.backgroundColor = colorVar;
          boton.style.color = '#fff';
          inputHidden.value = valor;

          const contenedor = opcion.querySelector('.c0');
          contenedor.style.boxShadow = `0 0 0px 2px ${colorVar}`;
          contenedor.style.position = 'relative';

          const check = document.createElement('span');
          check.className = 'check';
          check.innerHTML = `
              <span style="width: 25px; position: absolute; top: 8px; right: -5px;">
              <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="${colorHexValue}">
              <path d="M0 0h24v24H0V0z" fill="#fff"/>
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29 5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z"/>
              </svg>
              </span>
          `;
          contenedor.appendChild(check);

          // Guardar en localStorage dependiendo del tipo
          if (opcionesRoles.includes(valor)) {
            localStorage.setItem('rol', valor);
          } else if (opcionesGenero.includes(valor)) {
            localStorage.setItem('genero', valor);
          }
      });
  });

  boton.addEventListener('click', (e) => {
    const rolSeleccionado = localStorage.getItem('rol');

    if (rolSeleccionado === 'proveedor' || rolSeleccionado === 'repartidor') {
        e.preventDefault(); // Evita que el formulario se envíe
        document.getElementById('modalAdvertencia').style.display = 'flex';
    }
});

});