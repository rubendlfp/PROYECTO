@extends('index')

@section('contenido_principal')
<style>
/* Estilos coherentes con la página principal */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 0;
}

.marketplace-section {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 20%, #667eea 100%);
    min-height: 80vh;
    padding: 4rem 0;
}

.marketplace-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.marketplace-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.marketplace-card img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.marketplace-card:hover img {
    transform: scale(1.05);
}

.btn-view-marketplace {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-view-marketplace:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.price-tag {
    background: linear-gradient(45deg, #00d2d3, #54a0ff);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    display: inline-block;
    margin: 10px 0;
}

.user-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
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

.section-title {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title h2 {
    font-size: 2.5rem;
    font-weight: bold;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
}

.section-title p {
    color: white;
    font-size: 1.1rem;
    opacity: 0.9;
}

.stats-container {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 3rem;
}

.stat-item {
    text-align: center;
    color: white;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.marketplace-grid {
    margin-top: 2rem;
}

.breadcrumb-custom {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
}

.breadcrumb-custom a {
    color: white;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-custom a:hover {
    color: #f8f9fa;
    text-decoration: underline;
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <nav class="breadcrumb-custom">
            <a href="{{ route('principal') }}">Inicio</a>
            <span class="mx-2">/</span>
            <span>Compraventa</span>
        </nav>
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-handshake me-3"></i>COMPRAVENTA
            </h1>
            <p class="lead mb-0">Interactúa con otros usuarios de la aplicación para encontrar lo que buscas</p>
        </div>
    </div>
</section>

<!-- Marketplace Section -->
<section class="marketplace-section">
    <div class="container">
        <!-- Stats Container -->
        <div class="stats-container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ count($datosCompraventa) }}</div>
                        <div class="stat-label">Productos Disponibles</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-users"></i></div>
                        <div class="stat-label">Comunidad Activa</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-shield-alt"></i></div>
                        <div class="stat-label">Compra Segura</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-shipping-fast"></i></div>
                        <div class="stat-label">Envío Rápido</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-title">
            <h2>Productos de la Comunidad</h2>
            <p>Descubre productos únicos vendidos por otros usuarios</p>
        </div>
        
        <div class="marketplace-grid">
            <div class="row g-4">
                @forelse ($datosCompraventa as $index => $producto)
                <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="card marketplace-card h-100">
                        <div class="position-relative">
                            <img class="card-img-top" src="{{asset($producto->imagen)}}" alt="{{ $producto->nombre_producto }}" />
                            <div class="user-badge">
                                <i class="fas fa-user me-1"></i>Usuario
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-center mb-3">{{ $producto->nombre_producto }}</h5>
                            <div class="text-center mt-auto">
                                <div class="price-tag">
                                    <i class="fas fa-tag me-2"></i>{{ number_format($producto->precio, 2) }} €
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <form action="{{route('productoCompraventa', $producto->id)}}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id_borrar" value="{{$producto->id}}">
                                <button class="btn btn-view-marketplace" type="submit">
                                    <i class="fas fa-eye me-2"></i>Ver Producto
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5" style="color: white;">
                        <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.7;"></i>
                        <h3>No hay productos disponibles</h3>
                        <p>Sé el primero en publicar un producto en el marketplace</p>
                        @if(Auth::check())
                        <a href="{{ route('venderProducto') }}" class="btn btn-view-marketplace">
                            <i class="fas fa-plus me-2"></i>Vender Producto
                        </a>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        @if(Auth::check() && count($datosCompraventa) > 0)
        <div class="text-center mt-5">
            <a href="{{ route('menuNuevoCompraventa') }}" class="btn" style="background: linear-gradient(45deg, #ff6b6b, #ee5a24); color: white; padding: 15px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);">
                <i class="fas fa-plus me-2"></i>Vender Producto
            </a>
        </div>
        @endif
    </div>
</section>

<script>
// Animaciones para las tarjetas al cargar
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.animate-fade-in');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

@endsection