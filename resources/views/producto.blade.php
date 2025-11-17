{{--
===========================================
VISTA: Detalle de Producto
===========================================
Propósito: Mostrar información detallada de un producto individual
Acceso: Público (todos los usuarios)
Funcionalidad:
  - Carrusel con 3 imágenes del producto (img2, img3, img4)
  - Información: título, precio, descripción, tipo/categoría
  - Formulario para agregar al carrito (con AJAX)
  - Formulario para agregar a favoritos
  - Sección de beneficios (envío gratis, devoluciones, garantía)
  - Breadcrumb de navegación
Variables recibidas: $producto (objeto con todos los datos del producto)
Ruta: route('mostrarProductoUnico', ['id' => $producto->id])
--}}

@extends('index')

@section('contenido_principal')
{{-- === ESTILOS CSS PERSONALIZADOS === --}}
<style>
/* === HERO DE PRODUCTO === */
/* Banner superior con gradiente morado */
.product-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

/* === SECCIÓN PRINCIPAL === */
/* Fondo gris claro para toda la sección de detalles */
.product-detail-section {
    background: #f8f9fa;
    min-height: 70vh;
    padding: 2rem 0;
}

/* === TARJETA DE PRODUCTO === */
/* Card contenedor principal con sombra y bordes redondeados */
.product-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

/* Efecto hover: eleva la tarjeta */
.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

/* === CARRUSEL DE IMÁGENES === */
/* Contenedor del carrusel con bordes redondeados */
.carousel-container {
    border-radius: 10px;
    overflow: hidden;
    background: #f8f9fa;
}

/* Imágenes del carrusel: altura fija 450px, objeto-fit cover */
.carousel-item img {
    height: 450px;
    object-fit: cover;
    width: 100%;
}

/* Controles de navegación (flechas izquierda/derecha) */
/* Botones circulares con fondo morado semitransparente */
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

/* Hover en controles: aumenta opacidad */
.carousel-control-prev:hover, .carousel-control-next:hover {
    opacity: 1;
    background: rgba(102, 126, 234, 1);
}

/* Posición de flecha izquierda */
.carousel-control-prev {
    left: 15px;
}

/* Posición de flecha derecha */
.carousel-control-next {
    right: 15px;
}

/* === INDICADORES DEL CARRUSEL === */
/* Posición inferior de los puntos indicadores */
.carousel-indicators {
    bottom: 15px;
}

/* Estilo de cada punto indicador: círculo pequeño morado */
.carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.8) !important;
    margin: 0 3px;
    opacity: 0.6;
    transition: all 0.3s ease;
}

/* Indicador activo: más opaco y más grande */
.carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.2);
}

/* === TÍTULO DEL PRODUCTO === */
/* Título grande y bold */
.product-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

/* === PRECIO DEL PRODUCTO === */
/* Badge con gradiente morado, forma de píldora */
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

/* === DESCRIPCIÓN DEL PRODUCTO === */
/* Caja gris con borde izquierdo morado */
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

/* === BOTÓN AÑADIR AL CARRITO === */
/* Botón verde con gradiente y forma de píldora */
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

/* Hover: oscurece y eleva */
.btn-add-cart:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
}

/* === BOTÓN AÑADIR A FAVORITOS === */
/* Botón rojo/rosa con gradiente */
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

/* Hover en favoritos: oscurece y eleva */
.btn-add-favorite:hover {
    background: linear-gradient(45deg, #c82333, #d91a72);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    color: white;
}

/* === ANIMACIÓN DE ENTRADA === */
/* Clase para animación fadeInUp */
.animate-fade-in {
    animation: fadeInUp 0.6s ease forwards;
}

/* Keyframe: aparece desde abajo con fade */
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

/* === INFORMACIÓN DEL PRODUCTO === */
/* Padding para la columna de información */
.product-info {
    padding: 2rem;
}

/* === BREADCRUMB PERSONALIZADO === */
/* Breadcrumb con glassmorphism en el hero */
.breadcrumb-custom {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 0.8rem 1.2rem;
    margin-bottom: 1rem;
}

/* Enlaces del breadcrumb en color blanco */
.breadcrumb-custom a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Hover: color más claro y subrayado */
.breadcrumb-custom a:hover {
    color: #f8f9fa;
    text-decoration: underline;
}

/* === BADGE DE CATEGORÍA === */
/* Badge gris para mostrar el tipo de producto */
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

/* === SECCIÓN DE CARACTERÍSTICAS === */
/* Caja de beneficios (envío, devoluciones, garantía) */
.features-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

/* Cada item de característica centrado */
.feature-item {
    text-align: center;
    padding: 1rem 0.5rem;
}

/* Icono de característica en color morado */
.feature-item i {
    color: #667eea;
    margin-bottom: 0.5rem;
}

/* Título de cada característica */
.feature-item .feature-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

/* Descripción de cada característica */
.feature-item .feature-desc {
    color: #6c757d;
    font-size: 0.9rem;
}

/* === RESPONSIVE DESIGN === */
/* Ajustes para pantallas móviles */
@media (max-width: 768px) {
    /* Título más pequeño en móvil */
    .product-title {
        font-size: 1.8rem;
    }
    
    /* Precio más pequeño en móvil */
    .product-price {
        font-size: 1.2rem;
        padding: 10px 20px;
    }
    
    /* Imágenes de carrusel más bajas */
    .carousel-item img {
        height: 300px;
    }
    
    /* Menos padding en info */
    .product-info {
        padding: 1.5rem;
    }
    
    /* Botones a ancho completo en móvil */
    .btn-add-cart, .btn-add-favorite {
        width: 100%;
        margin-bottom: 10px;
        margin-right: 0;
    }
}
</style>

{{-- === SECCIÓN HERO === --}}
<!-- Banner superior con breadcrumb y título de la sección -->
<section class="product-hero">
    <div class="container">
        {{-- Breadcrumb de navegación con glassmorphism --}}
        <nav class="breadcrumb-custom">
            <a href="{{ route('principal') }}">Inicio</a>
            <span class="mx-2">/</span>
            <a href="{{ route('comprar') }}">Productos</a>
            <span class="mx-2">/</span>
            {{-- Nombre del producto actual (no es link) --}}
            <span>{{ $producto->titulo }}</span>
        </nav>
        <div class="text-center">
            {{-- Badge que muestra el tipo/categoría del producto --}}
            <div class="badge-category">{{ ucfirst($producto->tipo) }}</div>
            <h1 class="display-4 fw-bold mb-3">Detalles del Producto</h1>
            <p class="lead mb-0">Descubre todas las características de este increíble producto</p>
        </div>
    </div>
</section>

{{-- === SECCIÓN DE DETALLES DEL PRODUCTO === --}}
<!-- Sección principal con card del producto -->
<section class="product-detail-section">
    <div class="container">
        {{-- Card animada con fadeInUp --}}
        <div class="product-card animate-fade-in">
            <div class="row g-0">
                
                {{-- === COLUMNA IZQUIERDA: CARRUSEL DE IMÁGENES === --}}
                <div class="col-lg-6 p-4">
                    <div class="carousel-container">
                        {{-- Carrusel de Bootstrap con 3 imágenes (img2, img3, img4) --}}
                        <div id="carouselProduct" class="carousel slide" data-bs-ride="carousel">
                            
                            {{-- Indicadores: 3 puntos en la parte inferior --}}
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselProduct"
                                    data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            
                            {{-- Slides del carrusel --}}
                            <div class="carousel-inner">
                                {{-- Slide 1: img2 (activa por defecto) --}}
                                <div class="carousel-item active">
                                    <img src="{{asset($producto->img2)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                                {{-- Slide 2: img3 --}}
                                <div class="carousel-item">
                                    <img src="{{asset($producto->img3)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                                {{-- Slide 3: img4 --}}
                                <div class="carousel-item">
                                    <img src="{{asset($producto->img4)}}" class="d-block w-100" alt="{{ $producto->titulo }}">
                                </div>
                            </div>
                            
                            {{-- Control previo (flecha izquierda) --}}
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct"
                                data-bs-slide="prev">
                                <i class="fas fa-chevron-left text-white"></i>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            {{-- Control siguiente (flecha derecha) --}}
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct"
                                data-bs-slide="next">
                                <i class="fas fa-chevron-right text-white"></i>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- === COLUMNA DERECHA: INFORMACIÓN DEL PRODUCTO === --}}
                <div class="col-lg-6">
                    <div class="product-info">
                        {{-- Título del producto --}}
                        <h1 class="product-title">{{ $producto->titulo }}</h1>
                        
                        {{-- Precio con formato: 2 decimales + símbolo € --}}
                        <div class="product-price">
                            <i class="fas fa-tag me-2"></i>{{ number_format($producto->precio, 2) }} €
                        </div>
                        
                        {{-- Descripción del producto en caja gris --}}
                        <div class="product-description">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Descripción</h5>
                            <p class="mb-0">{{ $producto->descripcion }}</p>
                        </div>
                        
                        {{-- === FORMULARIOS DE ACCIÓN === --}}
                        <div class="d-flex flex-wrap gap-3">
                            {{-- Formulario 1: Añadir al carrito (con AJAX) --}}
                            <form action="{{ route('guardarProductoCarrito') }}" method="POST" class="d-inline add-to-cart-form">
                                @csrf
                                {{-- Campo oculto con ID del producto --}}
                                <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                                <button class="btn btn-add-cart" type="submit">
                                    <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                                </button>
                            </form>

                            {{-- Formulario 2: Añadir a favoritos --}}
                            <form action="{{ route('añadirFavorito') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                                <button class="btn btn-add-favorite" type="submit">
                                    <i class="fas fa-heart me-2"></i>Favoritos
                                </button>
                            </form>
                        </div>
                        
                        {{-- === SECCIÓN DE BENEFICIOS === --}}
                        <div class="features-section">
                            <h6 class="fw-bold mb-3 text-center">
                                <i class="fas fa-star me-2" style="color: #667eea;"></i>
                                Beneficios de Comprar con Nosotros
                            </h6>
                            <div class="row">
                                {{-- Beneficio 1: Envío Gratis --}}
                                <div class="col-4">
                                    <div class="feature-item">
                                        <i class="fas fa-shipping-fast fa-2x"></i>
                                        <div class="feature-title">Envío Gratis</div>
                                        <div class="feature-desc">En pedidos +50€</div>
                                    </div>
                                </div>
                                {{-- Beneficio 2: Devoluciones --}}
                                <div class="col-4">
                                    <div class="feature-item">
                                        <i class="fas fa-undo-alt fa-2x"></i>
                                        <div class="feature-title">Devoluciones</div>
                                        <div class="feature-desc">30 días gratis</div>
                                    </div>
                                </div>
                                {{-- Beneficio 3: Garantía --}}
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

{{-- === SCRIPTS === --}}
{{-- jQuery 3.6.0 para funcionalidad AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// === ANIMACIÓN AL CARGAR LA PÁGINA ===
// Aplica la animación fadeInUp a la tarjeta del producto después de 200ms
document.addEventListener('DOMContentLoaded', function() {
    const productCard = document.querySelector('.animate-fade-in');
    setTimeout(() => {
        productCard.style.opacity = '1';
        productCard.style.transform = 'translateY(0)';
    }, 200);
});

// === MANEJO DE AJAX PARA AÑADIR AL CARRITO ===
$(document).ready(function() {
    // Intercepta el submit del formulario con clase 'add-to-cart-form'
    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault(); // Previene el envío tradicional del formulario
        
        const form = $(this);
        const button = form.find('button[type="submit"]');
        const originalText = button.html(); // Guarda el texto original del botón
        
        // === ESTADO DE CARGA ===
        // Deshabilita el botón y muestra spinner mientras procesa
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin me-2"></i>Agregando...');
        
        // === PETICIÓN AJAX ===
        $.ajax({
            url: form.attr('action'), // route('guardarProductoCarrito')
            type: 'POST',
            data: form.serialize(), // Envía @csrf y id_producto
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Identifica como petición AJAX
            },
            
            // === ÉXITO ===
            success: function(response) {
                // Actualiza el contador del carrito en el navbar
                const cartCount = $('#cart-count');
                if (cartCount.length) {
                    // Si el badge ya existe, actualiza el número
                    cartCount.text(response.totalProductos);
                } else {
                    // Si no existe, crea el badge rojo con el contador
                    $('.fa-cart-shopping').parent().append(
                        `<span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            ${response.totalProductos}
                        </span>`
                    );
                }
                
                // Cambia el botón a estado de éxito (verde con check)
                button.html('<i class="fas fa-check me-2"></i>¡Agregado!');
                button.removeClass('btn-add-cart').addClass('btn-success');
                
                // Muestra alerta de éxito en la parte superior
                const alert = $(`
                    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-5" role="alert" style="z-index: 9999; min-width: 300px;">
                        <i class="fas fa-check-circle me-2"></i>${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                $('body').append(alert);
                
                // Oculta la alerta después de 3 segundos
                setTimeout(() => {
                    alert.fadeOut(400, function() { $(this).remove(); });
                }, 3000);
                
                // Restaura el botón a su estado original después de 2 segundos
                setTimeout(() => {
                    button.html(originalText);
                    button.removeClass('btn-success').addClass('btn-add-cart');
                    button.prop('disabled', false);
                }, 2000);
            },
            
            // === ERROR ===
            error: function(xhr) {
                // Restaura el botón
                button.html(originalText);
                button.prop('disabled', false);
                
                // Obtiene el mensaje de error del servidor o usa uno genérico
                const errorMsg = xhr.responseJSON?.message || 'Error al agregar el producto';
                
                // Muestra alerta de error (roja)
                const alert = $(`
                    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-5" role="alert" style="z-index: 9999; min-width: 300px;">
                        <i class="fas fa-exclamation-circle me-2"></i>${errorMsg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                $('body').append(alert);
                
                // Oculta la alerta después de 3 segundos
                setTimeout(() => {
                    alert.fadeOut(400, function() { $(this).remove(); });
                }, 3000);
            }
        });
    });
});
</script>

@endsection