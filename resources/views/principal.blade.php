@extends('index')

@section('contenido_principal')




<div>



<!-- Categories Section -->
<section id="categorias" class="categories-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">Nuestras Categorías</h2>
                <p class="lead text-muted">Explora nuestra amplia gama de productos organizados por categorías</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Ropa -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #ff6b6b, #ee5a24);">
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        <div class="category-icon mb-4">
                            <i class="fas fa-tshirt fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Ropa</h3>
                        <p class="mb-4">Encuentra las últimas tendencias en moda masculina y femenina</p>
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+500 productos disponibles</small>
                        </div>
                        <a href="{{ route('comprarRopa') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Explorar Ropa
                        </a>
                    </div>
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/ropa.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Ropa">
                    </div>
                </div>
            </div>
            
            <!-- Calzado -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #3742fa, #2f3542);">
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        <div class="category-icon mb-4">
                            <i class="fas fa-shoe-prints fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Calzado</h3>
                        <p class="mb-4">Zapatos deportivos, formales y casuales para toda ocasión</p>
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+300 modelos únicos</small>
                        </div>
                        <a href="{{ route('comprarCalzado') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Ver Calzado
                        </a>
                    </div>
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/zapatos.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Calzado">
                    </div>
                </div>
            </div>
            
            <!-- Complementos -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card h-100 position-relative overflow-hidden rounded-3 shadow-lg" 
                     style="background: linear-gradient(45deg, #00d2d3, #54a0ff);">
                    <div class="category-content p-5 text-center text-white position-relative" style="z-index: 2;">
                        <div class="category-icon mb-4">
                            <i class="fas fa-gem fa-4x"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Complementos deportivos</h3>
                        <p class="mb-4">Accesorios para deporte</p>
                        <div class="category-stats mb-4">
                            <small class="opacity-75">+200 accesorios exclusivos</small>
                        </div>
                        <a href="{{ route('comprarComplementos') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-right me-2"></i>Ver Complementos
                        </a>
                    </div>
                    <div class="category-bg position-absolute top-0 start-0 w-100 h-100 opacity-25">
                        <img src="{{asset('img/pagina_principal/img_prods/complementos.jpg')}}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="Complementos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-shipping-fast fa-3x mb-3"></i>
                    <h5 class="fw-bold">Envío Gratis</h5>
                    <p class="mb-0">En compras superiores a €50</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-undo fa-3x mb-3"></i>
                    <h5 class="fw-bold">Devoluciones</h5>
                    <p class="mb-0">30 días para cambios</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item">
                    <i class="fas fa-headset fa-3x mb-3"></i>
                    <h5 class="fw-bold">Soporte 24/7</h5>
                    <p class="mb-0">Atención al cliente siempre</p>
                </div>
            </div>
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

<style>
/* SportZone Navigation Styles */
.navbar .nav-link:hover {
    background: rgba(255,255,255,0.2) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.navbar-brand:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

.btn-outline-light:hover {
    background: rgba(255,255,255,0.9) !important;
    color: #ff6b35 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Animaciones y efectos personalizados */
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
}

.carousel-control-bg {
    background: rgba(255,255,255,0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.feature-item {
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}

/* Animaciones con CSS */
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

.animate__fadeInUp {
    animation: fadeInUp 0.8s ease;
}

.animate__delay-1s {
    animation-delay: 0.5s;
}

.animate__delay-2s {
    animation-delay: 1s;
}

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

.animate__fadeInRight {
    animation: fadeInRight 0.8s ease;
    animation-delay: 0.3s;
}
</style>

@endsection