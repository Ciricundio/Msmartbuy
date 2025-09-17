
const container = document.getElementById('productos-container');
const btnConfirmar = document.getElementById('confirmar-compra');
const mensaje = document.getElementById('mensaje');
const form = document.getElementById('form-compra');

console.log('Productos recibidos:', productos); // Debug

function mostrarProductos() {
    // Extraer el array de productos de la estructura
    let lista = productos;

    if (productos && productos.success && Array.isArray(productos.data)) {
        lista = productos.data;
    } else if (!Array.isArray(productos)) {
        console.error('Estructura de productos no válida:', productos);
        container.innerHTML = '<p>Error: Estructura de productos no válida.</p>';
        btnConfirmar.disabled = true;
        return;
    }

    if (!Array.isArray(lista) || lista.length === 0) {
        container.innerHTML = '<p>No hay productos para comprar.</p>';
        btnConfirmar.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    lista.forEach((p, index) => {
        // Validar que el producto tenga los campos necesarios
        if (!p.ID) {
            console.error(`Producto en índice ${index} no tiene ID:`, p);
            return;
        }

        const precio = Number(p.precio_final || p.precio_unitario || 0);
        const cantidad = Number(p.cantidad || 1);
        const subtotal = precio * cantidad;
        total += subtotal;

        html += `<div class="producto">
            <div>
                ${p.nombre || 'Producto sin nombre'}
                <small>${precio.toFixed(2)} × ${cantidad}</small>
            </div>
            <div>${subtotal.toFixed(2)}</div>
        </div>`;
    });

    html += `<div class="totales">
        <div><strong>Subtotal:</strong><strong>${total.toFixed(2)}</strong></div>
    </div>`;

    container.innerHTML = html;
}

// Actualizar totales cuando cambie el valor de envío
document.getElementById('valor_envio').addEventListener('input', function () {
    const valorEnvio = Number(this.value) || 0;
    const subtotal = calcularSubtotal();
    const totalFinal = subtotal + valorEnvio;

    // Actualizar la visualización de totales
    const totalesDiv = document.querySelector('.totales');
    if (totalesDiv) {
        totalesDiv.innerHTML = `
            <div><strong>Subtotal:</strong><strong>$${subtotal.toFixed(2)}</strong></div>
            <div>Envío: $${valorEnvio.toFixed(2)}</div>
            <div><strong>Total:</strong><strong>$${totalFinal.toFixed(2)}</strong></div>
        `;
    }
});

function calcularSubtotal() {
    // Extraer el array correcto de productos
    const lista = (productos && productos.success && Array.isArray(productos.data)) ? productos.data : productos;
    let total = 0;

    if (Array.isArray(lista)) {
        lista.forEach(p => {
            const precio = Number(p.precio_final || p.precio_unitario || 0);
            const cantidad = Number(p.cantidad || 1);
            total += precio * cantidad;
        });
    }

    return total;
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Validaciones antes de enviar
    const metodoPago = document.getElementById('metodo_pago').value;
    if (!metodoPago) {
        mensaje.style.color = 'red';
        mensaje.textContent = 'Por favor selecciona un método de pago.';
        return;
    }

    btnConfirmar.disabled = true;
    mensaje.style.color = 'black';
    mensaje.textContent = 'Procesando compra...';

    // Preparar datos - extraer solo el array de productos
    let productosParaEnviar = productos;

    // Si productos tiene la estructura {success: true, data: [...]}
    if (productos && productos.success && Array.isArray(productos.data)) {
        productosParaEnviar = productos.data;
    } else if (!Array.isArray(productos)) {
        mensaje.style.color = 'red';
        mensaje.textContent = 'Error: Estructura de productos no válida.';
        btnConfirmar.disabled = false;
        return;
    }

    const formData = {
        productos: productosParaEnviar, // Enviar solo el array de productos
        metodo_pago: parseInt(metodoPago),
        valor_envio: Number(document.getElementById('valor_envio').value) || 0,
        nota: document.getElementById('nota').value.trim()
    };

    console.log('Enviando datos:', formData); // Debug

    try {
        const res = await fetch('procesarCompra.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        console.log('Respuesta del servidor:', res.status, res.statusText); // Debug

        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status} ${res.statusText}`);
        }

        const contentType = res.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const textResponse = await res.text();
            console.error('Respuesta no JSON:', textResponse);
            throw new Error('El servidor no devolvió una respuesta JSON válida');
        }

        const data = await res.json();
        console.log('Datos de respuesta:', data); // Debug

        if (data.success) {
            mensaje.style.color = 'green';
            mensaje.textContent = data.message + ` (Factura ID: ${data.factura_id})`;

            // Opcional: redirigir después de unos segundos
            setTimeout(() => {
                window.location.href = '../../view/template/exito.php';
            }, 3000);
        } else {
            mensaje.style.color = 'red';
            mensaje.textContent = data.error || 'Error desconocido';
            btnConfirmar.disabled = false;
        }
    } catch (error) {
        console.error('Error completo:', error);
        mensaje.style.color = 'red';
        mensaje.textContent = `Error en la comunicación: ${error.message}`;
        btnConfirmar.disabled = false;
    }
});

// Inicializar
mostrarProductos();