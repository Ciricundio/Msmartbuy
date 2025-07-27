// CartAside.jsx - Animated cart sidebar component
const CartAside = ({ isOpen, items, total, loading, onClose, onRemoveItem }) => {
    const [checkoutLoading, setCheckoutLoading] = React.useState(false);

    const formatPrice = (price) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(price);
    };

    const handleCheckout = async () => {
        if (items.length === 0) {
            alert('Tu carrito está vacío');
            return;
        }

        setCheckoutLoading(true);

        try {
            // Crear preferencia de pago
            const response = await fetch('../../crearPreferenciaPago.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                // Simular proceso de pago exitoso
                const confirmPayment = confirm(
                    `¿Confirmar compra por ${formatPrice(data.data.total)}?\n\n` +
                    `Items: ${data.data.items.length} productos\n` +
                    `Total: ${formatPrice(data.data.total)}`
                );

                if (confirmPayment) {
                    // Confirmar pago
                    const confirmResponse = await fetch('../../confirmarPago.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: `payment_id=${data.data.id}&preference_id=${data.data.id}`
                    });

                    const confirmData = await confirmResponse.json();

                    if (confirmData.success) {
                        alert(confirmData.message);
                        // Cerrar el aside y refrescar la página para actualizar el carrito
                        onClose();
                        window.location.reload();
                    } else {
                        throw new Error(confirmData.message || 'Error al confirmar el pago');
                    }
                }
            } else {
                throw new Error(data.message || 'Error al crear la preferencia de pago');
            }
        } catch (error) {
            console.error('Error en checkout:', error);
            alert('Error al procesar la compra: ' + error.message);
        } finally {
            setCheckoutLoading(false);
        }
    };

    return (
        <div 
            className="cart-aside"
            style={{
                position: 'fixed',
                top: 0,
                right: isOpen ? 0 : '-400px',
                width: '400px',
                height: '100%',
                backgroundColor: 'white',
                zIndex: 1999,
                transition: 'right 0.3s ease',
                boxShadow: isOpen ? '-2px 0 10px rgba(0,0,0,0.1)' : 'none',
                display: 'flex',
                flexDirection: 'column'
            }}
        >
            {/* Header */}
            <div style={{
                padding: '20px',
                borderBottom: '1px solid #eee',
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                backgroundColor: '#f8f9fa'
            }}>
                <h3 style={{ margin: 0, color: '#333', fontSize: '18px' }}>
                    Mi Carrito ({items.length})
                </h3>
                <button 
                    onClick={onClose}
                    style={{
                        background: 'none',
                        border: 'none',
                        fontSize: '24px',
                        cursor: 'pointer',
                        color: '#666',
                        padding: '5px'
                    }}
                >
                    ×
                </button>
            </div>

            {/* Content */}
            <div style={{
                flex: 1,
                overflowY: 'auto',
                padding: '0'
            }}>
                {loading ? (
                    <div style={{
                        display: 'flex',
                        justifyContent: 'center',
                        alignItems: 'center',
                        height: '200px',
                        color: '#666'
                    }}>
                        Cargando...
                    </div>
                ) : items.length === 0 ? (
                    <div style={{
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                        justifyContent: 'center',
                        height: '300px',
                        color: '#666',
                        textAlign: 'center',
                        padding: '20px'
                    }}>
                        <i className="fas fa-shopping-cart" style={{ fontSize: '48px', marginBottom: '16px', color: '#ddd' }}></i>
                        <h4 style={{ margin: '0 0 8px 0' }}>Tu carrito está vacío</h4>
                        <p style={{ margin: 0, fontSize: '14px' }}>Agrega productos para comenzar a comprar</p>
                    </div>
                ) : (
                    <div style={{ padding: '0' }}>
                        {items.map((item, index) => (
                            <CartItem 
                                key={item.ID}
                                item={item}
                                onRemove={() => onRemoveItem(item.ID)}
                                formatPrice={formatPrice}
                                isLast={index === items.length - 1}
                            />
                        ))}
                    </div>
                )}
            </div>

            {/* Footer */}
            {items.length > 0 && (
                <div style={{
                    padding: '20px',
                    borderTop: '1px solid #eee',
                    backgroundColor: '#f8f9fa'
                }}>
                    <div style={{
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center',
                        marginBottom: '16px',
                        fontSize: '18px',
                        fontWeight: 'bold'
                    }}>
                        <span>Total:</span>
                        <span style={{ color: '#2ecb70' }}>{formatPrice(total)}</span>
                    </div>
                    <button 
                        onClick={handleCheckout}
                        disabled={checkoutLoading}
                        style={{
                            width: '100%',
                            padding: '12px',
                            backgroundColor: checkoutLoading ? '#6c757d' : '#2ecb70',
                            color: 'white',
                            border: 'none',
                            borderRadius: '8px',
                            fontSize: '16px',
                            fontWeight: 'bold',
                            cursor: checkoutLoading ? 'not-allowed' : 'pointer',
                            transition: 'background-color 0.3s ease'
                        }}
                        onMouseOver={(e) => {
                            if (!checkoutLoading) {
                                e.target.style.backgroundColor = '#24a159';
                            }
                        }}
                        onMouseOut={(e) => {
                            if (!checkoutLoading) {
                                e.target.style.backgroundColor = '#2ecb70';
                            }
                        }}
                    >
                        {checkoutLoading ? 'Procesando...' : 'Siguiente'}
                    </button>
                </div>
            )}
        </div>
    );
};

// Cart Item Component
const CartItem = ({ item, onRemove, formatPrice, isLast }) => {
    const [removing, setRemoving] = React.useState(false);

    const handleRemove = async () => {
        setRemoving(true);
        await onRemove();
        setRemoving(false);
    };

    return (
        <div style={{
            padding: '16px 20px',
            borderBottom: isLast ? 'none' : '1px solid #f0f0f0',
            display: 'flex',
            gap: '12px',
            opacity: removing ? 0.5 : 1,
            transition: 'opacity 0.3s ease'
        }}>
            {/* Product Image */}
            <div style={{
                width: '60px',
                height: '60px',
                borderRadius: '8px',
                overflow: 'hidden',
                flexShrink: 0,
                backgroundColor: '#f8f9fa'
            }}>
                <img 
                    src={`../../public/img/products/${item.foto}`}
                    alt={item.nombre}
                    style={{
                        width: '100%',
                        height: '100%',
                        objectFit: 'cover'
                    }}
                    onError={(e) => {
                        e.target.src = '../../public/img/products/default.jpg';
                    }}
                />
            </div>

            {/* Product Info */}
            <div style={{ flex: 1, minWidth: 0 }}>
                <h4 style={{
                    margin: '0 0 4px 0',
                    fontSize: '14px',
                    fontWeight: '600',
                    color: '#333',
                    overflow: 'hidden',
                    textOverflow: 'ellipsis',
                    whiteSpace: 'nowrap'
                }}>
                    {item.nombre}
                </h4>
                <p style={{
                    margin: '0 0 8px 0',
                    fontSize: '12px',
                    color: '#666',
                    textTransform: 'uppercase'
                }}>
                    {item.marca}
                </p>
                
                <div style={{
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center'
                }}>
                    <div>
                        <span style={{
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#2ecb70'
                        }}>
                            {formatPrice(item.precio_final)}
                        </span>
                        {item.descuento > 0 && (
                            <span style={{
                                fontSize: '12px',
                                color: '#999',
                                textDecoration: 'line-through',
                                marginLeft: '8px'
                            }}>
                                {formatPrice(item.precio_unitario)}
                            </span>
                        )}
                        <div style={{
                            fontSize: '12px',
                            color: '#666',
                            marginTop: '2px'
                        }}>
                            Cantidad: {item.cantidad}
                        </div>
                    </div>
                    
                    <button 
                        onClick={handleRemove}
                        disabled={removing}
                        style={{
                            background: 'none',
                            border: 'none',
                            color: '#dc3545',
                            cursor: removing ? 'not-allowed' : 'pointer',
                            fontSize: '16px',
                            padding: '4px'
                        }}
                        title="Eliminar del carrito"
                    >
                        <i className="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    );
};

// Export for use in other files
window.CartAside = CartAside;
