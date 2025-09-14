// Product Search JavaScript - Vanilla JS implementation for search functionality
class ProductSearch {
    constructor() {
        this.searchInput = document.querySelector('.search-box input');
        this.resultsContainer = null;
        this.debounceTimer = null;
        this.currentProducts = [];
        
        this.init();
    }

    init() {
        this.createResultsContainer();
        this.bindEvents();
    }

    createResultsContainer() {
        this.resultsContainer = document.createElement('div');
        this.resultsContainer.className = 'search-results-container';
        this.resultsContainer.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        `;
        
        const searchBox = document.querySelector('.search-box');
        searchBox.style.position = 'relative';
        searchBox.appendChild(this.resultsContainer);
    }

    bindEvents() {
        this.searchInput.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.handleSearch(e.target.value);
            }, 300);
        });

        // Close results when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box')) {
                this.hideResults();
            }
        });
    }

    async handleSearch(query) {
        if (query.trim().length < 2) {
            this.hideResults();
            return;
        }

        try {
            const response = await fetch(`../../buscarProducto.php?search=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data.success && data.data.length > 0) {
                this.currentProducts = data.data;
                this.displayResults(data.data);
            } else {
                this.showNoResults();
            }
        } catch (error) {
            console.error('Error searching products:', error);
            this.showError();
        }
    }

    displayResults(products) {
        this.resultsContainer.innerHTML = '';
        
        products.forEach(product => {
            const item = document.createElement('div');
            item.className = 'search-result-item';
            item.style.cssText = `
                display: flex;
                align-items: center;
                padding: 12px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background-color 0.2s;
            `;
            
            item.innerHTML = `
                <img src="../../public/img/products/${product.foto || 'default.jpg'}" 
                     alt="${product.nombre}" 
                     style="width: 50px; height: 50px; object-fit: cover; margin-right: 12px; border-radius: 4px;"
                     onerror="this.src='../../public/img/products/default.jpg'">
                <div style="flex: 1;">
                    <h4 style="margin: 0; font-size: 14px; font-weight: 600;">${product.nombre}</h4>
                    <p style="margin: 2px 0; font-size: 12px; color: #666;">${(product.descripcion || '').substring(0, 50)}...</p>
                    <p style="margin: 0; font-size: 14px; font-weight: bold; color: #ff6b35;">$${new Intl.NumberFormat('es-CO').format(product.precio_final || product.precio_unitario)}</p>
                </div>
            `;
            
            item.addEventListener('click', () => this.selectProduct(product));
            this.resultsContainer.appendChild(item);
        });

        this.showResults();
    }

    showNoResults() {
        this.resultsContainer.innerHTML = `
            <div style="padding: 20px; text-align: center; color: #666;">
                No se encontraron productos
            </div>
        `;
        this.showResults();
    }

    showError() {
        this.resultsContainer.innerHTML = `
            <div style="padding: 20px; text-align: center; color: #e74c3c;">
                Error al buscar productos
            </div>
        `;
        this.showResults();
    }

    showResults() {
        this.resultsContainer.style.display = 'block';
    }

    hideResults() {
        this.resultsContainer.style.display = 'none';
    }

    selectProduct(product) {
        this.hideResults();
        this.searchInput.value = '';
        openProductModal(product);
    }
}

// Product Modal functionality
class ProductModal {
    constructor() {
        this.modal = null;
        this.currentProduct = null;
        this.init();
    }

    init() {
        this.createModal();
    }

    createModal() {
        this.modal = document.createElement('div');
        this.modal.className = 'product-modal-overlay';
        this.modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        this.modal.innerHTML = `
            <div class="product-modal-content" style="
                background: white;
                border-radius: 12px;
                max-width: 800px;
                width: 90%;
                max-height: 90vh;
                overflow-y: auto;
                transform: scale(0.8);
                transition: transform 0.3s ease;
            ">
                <button class="modal-close" style="
                    position: absolute;
                    top: 15px;
                    right: 15px;
                    background: none;
                    border: none;
                    font-size: 24px;
                    cursor: pointer;
                    z-index: 1;
                ">×</button>
                
                <div class="modal-body" style="padding: 20px;">
                    <div class="product-detail-layout">
                        <div class="product-image-section">
                            <img id="modal-product-image" src="" alt="" style="
                                width: 100%;
                                max-height: 400px;
                                object-fit: cover;
                                border-radius: 8px;
                            ">
                        </div>
                        
                        <div class="product-info-section">
                            <h1 id="modal-product-name" style="margin: 0 0 10px 0; color: #333;"></h1>
                            <p id="modal-product-brand" style="color: #666; margin: 0 0 15px 0;"></p>
                            <p id="modal-product-description" style="color: #555; line-height: 1.6; margin-bottom: 20px;"></p>
                            
                            <div class="price-display" style="margin-bottom: 20px;">
                                <span id="modal-product-price" style="
                                    font-size: 24px;
                                    font-weight: bold;
                                    color: #ff6b35;
                                "></span>
                                <span id="modal-product-original-price" style="
                                    font-size: 18px;
                                    color: #999;
                                    text-decoration: line-through;
                                    margin-left: 10px;
                                "></span>
                            </div>
                            
                            <div class="product-details" style="margin-bottom: 25px;">
                                <p><strong>SKU:</strong> <span id="modal-product-sku"></span></p>
                                <p><strong>Stock:</strong> <span id="modal-product-stock"></span> disponibles</p>
                                <p><strong>Peso:</strong> <span id="modal-product-weight"></span></p>
                            </div>
                            
                            <div class="action-buttons" style="display: flex; gap: 15px;">
                                <button id="add-to-cart-btn" class="btn btn-primary" style="
                                    flex: 1;
                                    padding: 12px 24px;
                                    background: #ff6b35;
                                    color: white;
                                    border: none;
                                    border-radius: 20px;
                                    cursor: pointer;
                                    font-size: 16px;
                                ">Agregar al Carrito</button>
                                
                                 <!--<button id="buy-now-btn" class="btn btn-success" style="
                                    flex: 1;
                                    padding: 12px 24px;
                                    background: #28a745;
                                    color: white;
                                    border: none;
                                    border-radius: 20px;
                                    cursor: pointer;
                                    font-size: 16px;
                                ">Comprar Ahora</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(this.modal);

        // Event listeners
        this.modal.querySelector('.modal-close').addEventListener('click', () => this.close());
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.close();
        });

        this.modal.querySelector('#add-to-cart-btn').addEventListener('click', () => this.addToCart());
        /* this.modal.querySelector('#buy-now-btn').addEventListener('click', () => this.buyNow()); */
    }

    open(product) {
        this.currentProduct = product;
        this.updateModalContent(product);
        
        this.modal.style.display = 'flex';
        setTimeout(() => {
            this.modal.style.opacity = '1';
            this.modal.querySelector('.product-modal-content').style.transform = 'scale(1)';
        }, 10);
    }

    close() {
        this.modal.style.opacity = '0';
        this.modal.querySelector('.product-modal-content').style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            this.modal.style.display = 'none';
        }, 300);
    }

    updateModalContent(product) {
        const modalImage = document.getElementById('modal-product-image');
        modalImage.src = `../../public/img/products/${product.foto || 'default.jpg'}`;
        modalImage.alt = product.nombre;
        modalImage.onerror = function() { this.src = '../../public/img/products/default.jpg'; };
        
        document.getElementById('modal-product-name').textContent = product.nombre;
        document.getElementById('modal-product-brand').textContent = product.marca;
        document.getElementById('modal-product-description').textContent = product.descripcion || 'Sin descripción disponible';
        document.getElementById('modal-product-price').textContent = `$${new Intl.NumberFormat('es-CO').format(product.precio_final || product.precio_unitario)}`;
        
        if (product.descuento > 0) {
            document.getElementById('modal-product-original-price').textContent = `$${new Intl.NumberFormat('es-CO').format(product.precio_unitario)}`;
            document.getElementById('modal-product-original-price').style.display = 'inline';
        } else {
            document.getElementById('modal-product-original-price').style.display = 'none';
        }
        
        document.getElementById('modal-product-sku').textContent = product.sku || 'N/A';
        document.getElementById('modal-product-stock').textContent = product.cantidad || 0;
        document.getElementById('modal-product-weight').textContent = product.peso || 'N/A';
    }

    async addToCart() {
        try {
            const response = await fetch('../../agregarAlCarrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${this.currentProduct.ID}&quantity=1`
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Producto agregado al carrito');
                this.close();
            } else {
                alert(data.message || 'Error al agregar al carrito');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al agregar al carrito');
        }
    }

    buyNow() {
        // Redirect to checkout flow
        window.location.href = `../../controller/pago/crearPreferenciaPago.php?product_id=${this.currentProduct.ID}&quantity=1`;
    }
}

// Global functions
let productModal;
let productSearch;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    productModal = new ProductModal();
    productSearch = new ProductSearch();
});

// Global function to open product modal
function openProductModal(product) {
    productModal.open(product);
}

// Global function to open product detail
function openProductDetail(productId) {
    fetch(`../../detalleProducto.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                productModal.open(data.data);
            } else {
                alert(data.message || 'Producto no encontrado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el producto');
        });
}
