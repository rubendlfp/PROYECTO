{{--
===========================================
VISTA: Página Principal
===========================================
Propósito: Landing page principal que muestra las categorías de productos disponibles
Acceso: Público (todos los usuarios)
Funcionalidad: 
  - Muestra 3 categorías principales: Ropa, Calzado, Complementos
  - Sección de características/beneficios (envío gratis, devoluciones, soporte 24/7, pago seguro)
  - Cards con gradientes y efectos hover
Ruta: route('principal')
--}}

@extends('index')

@section('contenido_principal')




<div>



{{-- === SECCIÓN DE CATEGORÍAS === --}}
<!-- Sección que muestra las 3 categorías principales de productos -->
<section id="categorias" class="categories-section py-5">
    <div class="container">
        {{-- Encabezado de la sección --}}
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">Nuestras Categorías</h2>
                <p class="lead text-muted">Explora nuestra amplia gama de productos organizados por categorías</p>
            </div>
        </div>
        
        {{-- Grid de 3 categorías (Ropa, Calzado, Complementos) --}}
        <div class="row g-4">
            
            {{-- === CATEGORÍA 1: ROPA === --}}
            <div class="col-lg-4 col-md-6">
                {{-- Card con gradiente rojo-naranja, imagen de fondo y contenido superpuesto --}}
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #ff6b6b, #ee5a24);">
                    {{-- Contenido frontal (z-index: 2 para estar sobre la imagen) --}}
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        {{-- Icono de camiseta --}}
                        <div class="category-icon mb-4">
                            <i class="fas fa-tshirt fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Ropa</h3>
                        <p class="mb-4">Encuentra las últimas tendencias en moda masculina y femenina</p>
                        {{-- Estadística de productos disponibles --}}
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+500 productos disponibles</small>
                        </div>
                        {{-- Botón que redirige a la ruta de productos de ropa --}}
                        <a href="{{ route('comprarRopa') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Explorar Ropa
                        </a>
                    </div>
                    {{-- Imagen de fondo con opacidad reducida --}}
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/ropa.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Ropa">
                    </div>
                </div>
            </div>
            
            {{-- === CATEGORÍA 2: CALZADO === --}}
            <div class="col-lg-4 col-md-6">
                {{-- Card con gradiente azul oscuro --}}
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #3742fa, #2f3542);">
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        {{-- Icono de huellas de zapatos --}}
                        <div class="category-icon mb-4">
                            <i class="fas fa-shoe-prints fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Calzado</h3>
                        <p class="mb-4">Zapatos deportivos, formales y casuales para toda ocasión</p>
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+300 modelos únicos</small>
                        </div>
                        {{-- Botón que redirige a la ruta de productos de calzado --}}
                        <a href="{{ route('comprarCalzado') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Ver Calzado
                        </a>
                    </div>
                    {{-- Imagen de fondo --}}
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/zapatos.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Calzado">
                    </div>
                </div>
            </div>
            
            {{-- === CATEGORÍA 3: COMPLEMENTOS DEPORTIVOS === --}}
            <div class="col-lg-4 col-md-6">
                {{-- Card con gradiente cyan-azul --}}
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #00d2d3, #54a0ff);">
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        {{-- Icono de gema para accesorios --}}
                        <div class="category-icon mb-4">
                            <i class="fas fa-gem fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Complementos deportivos</h3>
                        <p class="mb-4">Accesorios para deporte</p>
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+200 accesorios exclusivos</small>
                        </div>
                        {{-- Botón que redirige a la ruta de complementos --}}
                        <a href="{{ route('comprarComplementos') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Ver Complementos
                        </a>
                    </div>
                    {{-- Imagen de fondo --}}
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/complementos.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Complementos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- === SECCIÓN DE CARACTERÍSTICAS/BENEFICIOS === --}}
<!-- Features Section - Muestra las ventajas de comprar en la tienda -->
<section class="features-section py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        {{-- Grid de 4 características con iconos y descripciones --}}
        <div class="row text-center text-white">
            
            {{-- Feature 1: Envío Gratis --}}
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-shipping-fast fa-3x mb-3"></i>
                    <h5 class="fw-bold">Envío Gratis</h5>
                    <p class="mb-0">En compras superiores a €50</p>
                </div>
            </div>
            
            {{-- Feature 2: Devoluciones --}}
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-undo fa-3x mb-3"></i>
                    <h5 class="fw-bold">Devoluciones</h5>
                    <p class="mb-0">30 días para cambios</p>
                </div>
            </div>
            
            {{-- Feature 3: Soporte 24/7 --}}
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-headset fa-3x mb-3"></i>
                    <h5 class="fw-bold">Soporte 24/7</h5>
                    <p class="mb-0">Atención al cliente siempre</p>
                </div>
            </div>
            
            {{-- Feature 4: Pago Seguro --}}
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-lock fa-3x mb-3"></i>
                    <h5 class="fw-bold">Pago Seguro</h5>
                    <p class="mb-0">Transacciones protegidas</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- === ESTILOS CSS PERSONALIZADOS === --}}
<style>
/* === ESTILOS DE NAVEGACIÓN === */
/* Efecto hover en los enlaces de navegación */
.navbar .nav-link:hover {
    background: rgba(255,255,255,0.2) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Efecto hover en el logo/marca */
.navbar-brand:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Efecto hover en botones outline-light */
.btn-outline-light:hover {
    background: rgba(255,255,255,0.9) !important;
    color: #ff6b35 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* === ANIMACIONES Y EFECTOS PERSONALIZADOS === */
/* Estilo base para las tarjetas de categorías */
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

/* Efecto hover: eleva la tarjeta y aumenta la sombra */
.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
}

/* Estilo para controles de carrusel (no usado en esta vista pero definido) */
.carousel-control-bg {
    background: rgba(255,255,255,0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

/* Estilo base para items de características */
.feature-item {
    transition: transform 0.3s ease;
}

/* Efecto hover: ligera elevación */
.feature-item:hover {
    transform: translateY(-5px);
}

/* === ANIMACIONES CON CSS KEYFRAMES === */
/* Animación fadeInUp: elemento aparece desde abajo */
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

/* Clase para aplicar animación fadeInUp */
.animate__fadeInUp {
    animation: fadeInUp 0.8s ease;
}

/* Clase para delay de 0.5s */
.animate__delay-1s {
    animation-delay: 0.5s;
}

/* Clase para delay de 1s */
.animate__delay-2s {
    animation-delay: 1s;
}

/* Animación fadeInRight: elemento aparece desde la derecha */
@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Clase para aplicar animación fadeInRight con delay de 0.3s */
.animate__fadeInRight {
    animation: fadeInRight 0.8s ease;
    animation-delay: 0.3s;
}
</style>

@endsection