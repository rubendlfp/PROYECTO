@extends('index')

@section('contenido_principal')
<style>
/* Estilos modernos y limpios para la página de producto */
.product-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.product-detail-section {
    background: #f8f9fa;
    min-height: 70vh;
    padding: 2rem 0;
}

.product-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.carousel-container {
    border-radius: 10px;
    overflow: hidden;
    background: #f8f9fa;
}

.carousel-item img {
    height: 450px;
    object-fit: cover;
    width: 100%;
}

.carousel-control-prev, .carousel-control-next {
    width: 45px;
    height: 45px;
    background: rgba(102, 126, 234, 0.8);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
    transition: all 0.3s ease;
}

.carousel-control-prev:hover, .carousel-control-next:hover {
    opacity: 1;
    background: rgba(102, 126, 234, 1);
}

.carousel-control-prev {
    left: 15px;
}

.carousel-control-next {
    right: 15px;
}

.carousel-indicators {
    bottom: 15px;
}

.carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.8) !important;
    margin: 0 3px;
    opacity: 0.6;
    transition: all 0.3s ease;
}

.carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.2);
}

.product-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.product-price {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 1.4rem;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 1.5rem;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.product-description {
    font-size: 1rem;
    line-height: 1.6;
    color: #495057;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.btn-add-cart {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    margin-right: 10px;
    margin-bottom: 10px;
}

.btn-add-cart:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
}

.btn-add-favorite {
    background: linear-gradient(45deg, #dc3545, #e83e8c);
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    margin-bottom: 10px;
}

.btn-add-favorite:hover {
    background: linear-gradient(45deg, #c82333, #d91a72);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    color: white;
}

.animate-fade-in {
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-info {
    padding: 2rem;
}

.breadcrumb-custom {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 0.8rem 1.2rem;
    margin-bottom: 1rem;
}

.breadcrumb-custom a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.breadcrumb-custom a:hover {
    color: #f8f9fa;
    text-decoration: underline;
}

.badge-category {
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
    display: inline-block;
    font-weight: 500;
}

.features-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.feature-item {
    text-align: center;
    padding: 1rem 0.5rem;
}

.feature-item i {
    color: #667eea;
    margin-bottom: 0.5rem;
}

.feature-item .feature-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.feature-item .feature-desc {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-title {
        font-size: 1.8rem;
    }
    
    .product-price {
        font-size: 1.2rem;
        padding: 10px 20px;
    }
    
    .carousel-item img {
        height: 300px;
    }
    
    .product-info {
        padding: 1.5rem;
    }
    
    .btn-add-cart, .btn-add-favorite {
        width: 100%;
        margin-bottom: 10px;
        margin-right: 0;
    }
}
</style>

<!-- Hero Section -->
<section class="product-hero">
    <div class="container">
        <nav class="breadcrumb-custom">
            <a href="{{ route('principal') }}">Inicio</a>
            <span class="mx-2">/</span>
            <a href="{{ route('comprar') }}">Productos</a>
            <span class="mx-2">/</span>
            <span>{{ $producto->titulo }}</span>
        </nav>
        <div class="text-center">
            <div class="badge-category">{{ ucfirst($producto->tipo) }}</div>
            <h1 class="display-4 fw-bold mb-3">Detalles del Producto</h1>
            <p class="lead mb-0">Descubre todas las características de este increíble producto</p>
        </div>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-section">
    <div class="container">
        <div class="product-card animate-fade-in">
            <div class="row g-0">
                <div class="col-lg-6 p-4">
                    <div class="carousel-container">
                        <div id="carouselProduct" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{asset($producto->img2)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{asset($producto->img3)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{asset($producto->img4)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct"
                                data-bs-slide="prev">
                                <i class="fas fa-chevron-left text-white"></i>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct"
                                data-bs-slide="next">
                                <i class="fas fa-chevron-right text-white"></i>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="product-info">
                        <h1 class="product-title">{{ $producto->titulo }}</h1>
                        
                        <div class="product-price">
                            <i class="fas fa-tag me-2"></i>{{ number_format($producto->precio, 2) }} €
                        </div>
                        
                        <div class="product-description">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Descripción</h5>
                            <p class="mb-0">{{ $producto->descripcion }}</p>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-3">
                            <form action="{{ route('guardarProductoCarrito') }}" method="POST" class="d-inline add-to-cart-form">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                                <button class="btn btn-add-cart" type="submit">
                                    <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                                </button>
                            </form>

                            <form action="{{ route('añadirFavorito') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                                <button class="btn btn-add-favorite" type="submit">
                                    <i class="fas fa-heart me-2"></i>Favoritos
                                </button>
                            </form>
                        </div>
                        
                        <div class="features-section">
                            <h6 class="fw-bold mb-3 text-center">
                                <i class="fas fa-star me-2" style="color: #667eea;"></i>
                                Beneficios de Comprar con Nosotros
                            </h6>
                            <div class="row">
                                <div class="col-4">
                                    <div class="feature-item">
                                        <i class="fas fa-shipping-fast fa-2x"></i>
                                        <div class="feature-title">Envío Gratis</div>
                                        <div class="feature-desc">En pedidos +50€</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="feature-item">
                                        <i class="fas fa-undo-alt fa-2x"></i>
                                        <div class="feature-title">Devoluciones</div>
                                        <div class="feature-desc">30 días gratis</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="feature-item">
                                        <i class="fas fa-shield-alt fa-2x"></i>
                                        <div class="feature-title">Garantía</div>
                                        <div class="feature-desc">2 años</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Animación al cargar
document.addEventListener('DOMContentLoaded', function() {
    const productCard = document.querySelector('.animate-fade-in');
    setTimeout(() => {
        productCard.style.opacity = '1';
        productCard.style.transform = 'translateY(0)';
    }, 200);
});

// Manejar agregar al carrito con AJAX
$(document).ready(function() {
    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const button = form.find('button[type="submit"]');
        const originalText = button.html();
        
        // Deshabilitar botón y mostrar loading
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin me-2"></i>Agregando...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Actualizar contador del carrito
                const cartCount = $('#cart-count');
                if (cartCount.length) {
                    cartCount.text(response.totalProductos);
                } else {
                    // Si no existe el badge, crearlo
                    $('.fa-cart-shopping').parent().append(
                        `<span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            ${response.totalProductos}
                        </span>`
                    );
                }
                
                // Mostrar mensaje de éxito
                button.html('<i class="fas fa-check me-2"></i>¡Agregado!');
                button.removeClass('btn-add-cart').addClass('btn-success');
                
                // Mostrar alerta de Bootstrap
                const alert = $(`
                    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-5" role="alert" style="z-index: 9999; min-width: 300px;">
                        <i class="fas fa-check-circle me-2"></i>${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                $('body').append(alert);
                
                // Ocultar alerta después de 3 segundos
                setTimeout(() => {
                    alert.fadeOut(400, function() { $(this).remove(); });
                }, 3000);
                
                // Restaurar botón después de 2 segundos
                setTimeout(() => {
                    button.html(originalText);
                    button.removeClass('btn-success').addClass('btn-add-cart');
                    button.prop('disabled', false);
                }, 2000);
            },
            error: function(xhr) {
                // Mostrar error
                button.html(originalText);
                button.prop('disabled', false);
                
                const errorMsg = xhr.responseJSON?.message || 'Error al agregar el producto';
                const alert = $(`
                    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-5" role="alert" style="z-index: 9999; min-width: 300px;">
                        <i class="fas fa-exclamation-circle me-2"></i>${errorMsg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                $('body').append(alert);
                
                setTimeout(() => {
                    alert.fadeOut(400, function() { $(this).remove(); });
                }, 3000);
            }
        });
    });
});
</script>

@endsection