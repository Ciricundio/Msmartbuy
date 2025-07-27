// FavoritesAside.jsx - Animated favorites sidebar component
const FavoritesAside = ({ isOpen, items, loading, onClose, onRemoveItem, onAddToCart }) => {
    const formatPrice = (price) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(price);
    };

    return (
        <div 
            className="favorites-aside"
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
                    <i className="fas fa-heart" style={{ color: '#e74c3c', marginRight: '8px' }}></i>
                    Mis Favoritos ({items.length})
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
                        <i className="fas fa-heart" style={{ fontSize: '48px', marginBottom: '16px', color: '#ddd' }}></i>
                        <h4 style={{ margin: '0 0 8px 0' }}>No tienes favoritos</h4>
                        <p style={{ margin: 0, fontSize: '14px' }}>Agrega productos a tus favoritos para verlos aquí</p>
                    </div>
                ) : (
                    <div style={{ padding: '0' }}>
                        {items.map((item, index) => (
                            <FavoriteItem 
                                key={item.ID}
                                item={item}
                                onRemove={() => onRemoveItem(item.ID)}
                                onAddToCart={() => onAddToCart(item.ID)}
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
                    backgroundColor: '#f8f9fa',
                    textAlign: 'center'
                }}>
                    <p style={{
                        margin: 0,
                        fontSize: '14px',
                        color: '#666'
                    }}>
                        {items.length} producto{items.length !== 1 ? 's' : ''} en favoritos
                    </p>
                </div>
            )}
        </div>
    );
};

// Favorite Item Component
const FavoriteItem = ({ item, onRemove, onAddToCart, formatPrice, isLast }) => {
    const [removing, setRemoving] = useState(false);
    const [addingToCart, setAddingToCart] = useState(false);

    const handleRemove = async () => {
        setRemoving(true);
        await onRemove();
        setRemoving(false);
    };

    const handleAddToCart = async () => {
        setAddingToCart(true);
        await onAddToCart();
        setAddingToCart(false);
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
                width: '80px',
                height: '80px',
                borderRadius: '8px',
                overflow: 'hidden',
                flexShrink: 0,
                backgroundColor: '#f8f9fa',
                position: 'relative'
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
                {item.descuento > 0 && (
                    <div style={{
                        position: 'absolute',
                        top: '4px',
                        left: '4px',
                        backgroundColor: '#e74c3c',
                        color: 'white',
                        fontSize: '10px',
                        padding: '2px 4px',
                        borderRadius: '4px',
                        fontWeight: 'bold'
                    }}>
                        -{item.descuento}%
                    </div>
                )}
            </div>

            {/* Product Info */}
            <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'flex-start',
                    marginBottom: '8px'
                }}>
                    <h4 style={{
                        margin: 0,
                        fontSize: '14px',
                        fontWeight: '600',
                        color: '#333',
                        overflow: 'hidden',
                        textOverflow: 'ellipsis',
                        whiteSpace: 'nowrap',
                        flex: 1,
                        marginRight: '8px'
                    }}>
                        {item.nombre}
                    </h4>
                    <button 
                        onClick={handleRemove}
                        disabled={removing}
                        style={{
                            background: 'none',
                            border: 'none',
                            color: '#e74c3c',
                            cursor: removing ? 'not-allowed' : 'pointer',
                            fontSize: '16px',
                            padding: '2px'
                        }}
                        title="Eliminar de favoritos"
                    >
                        <i className="fas fa-heart"></i>
                    </button>
                </div>

                <p style={{
                    margin: '0 0 8px 0',
                    fontSize: '12px',
                    color: '#666',
                    textTransform: 'uppercase'
                }}>
                    {item.marca}
                </p>

                <p style={{
                    margin: '0 0 12px 0',
                    fontSize: '12px',
                    color: '#777',
                    overflow: 'hidden',
                    textOverflow: 'ellipsis',
                    whiteSpace: 'nowrap'
                }}>
                    {item.descripcion}
                </p>
                
                <div style={{
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center'
                }}>
                    <div>
                        <span style={{
                            fontSize: '16px',
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
                    </div>
                    
                    <button 
                        onClick={handleAddToCart}
                        disabled={addingToCart}
                        style={{
                            backgroundColor: addingToCart ? '#ccc' : '#2ecb70',
                            color: 'white',
                            border: 'none',
                            borderRadius: '6px',
                            padding: '6px 12px',
                            fontSize: '12px',
                            cursor: addingToCart ? 'not-allowed' : 'pointer',
                            transition: 'background-color 0.3s ease',
                            fontWeight: '500'
                        }}
                        onMouseOver={(e) => {
                            if (!addingToCart) e.target.style.backgroundColor = '#24a159';
                        }}
                        onMouseOut={(e) => {
                            if (!addingToCart) e.target.style.backgroundColor = '#2ecb70';
                        }}
                    >
                        {addingToCart ? (
                            <>
                                <i className="fas fa-spinner fa-spin" style={{ marginRight: '4px' }}></i>
                                Agregando...
                            </>
                        ) : (
                            <>
                                <i className="fas fa-shopping-cart" style={{ marginRight: '4px' }}></i>
                                Agregar
                            </>
                        )}
                    </button>
                </div>
            </div>
        </div>
    );
};

// Export for use in other files
window.FavoritesAside = FavoritesAside;
