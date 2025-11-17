@extends('index')

@section('contenido_principal')
<style>
/* Estilos coherentes con la página principal */
.hero-section {
    background: linear-gradient(135deg, #e056fd 0%, #f093fb 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 0;
}

.favorites-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    min-height: 80vh;
    padding: 4rem 0;
}

.favorite-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.favorite-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.favorite-card img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.favorite-card:hover img {
    transform: scale(1.05);
}

.btn-remove-favorite {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.btn-remove-favorite:hover {
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
}

.btn-view-product {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-left: 10px;
}

.btn-view-product:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    color: white;
}

.favorite-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(45deg, #e056fd, #f093fb);
    color: white;
    padding: 8px 12px;
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

.empty-favorites {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    color: white;
}

.stats-container {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 3rem;
    text-align: center;
    color: white;
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
            <span>Favoritos</span>
        </nav>
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-heart me-3"></i>MIS FAVORITOS
            </h1>
            <p class="lead mb-0">Todos tus productos favoritos en un solo lugar</p>
        </div>
    </div>
</section>

<!-- Favorites Section -->
<section class="favorites-section">
    <div class="container">
        @if(count($datosFavoritos) > 0)
        <!-- Stats Container -->
        <div class="stats-container">
            <h4><i class="fas fa-heart me-2"></i>Tienes {{ count($datosFavoritos) }} producto{{ count($datosFavoritos) != 1 ? 's' : '' }} en favoritos</h4>
            <p class="mb-0 opacity-75">¡Perfecto para tenerlos siempre a mano!</p>
        </div>

        <div class="section-title">
            <h2>Tus Productos Favoritos</h2>
            <p>Los productos que más te gustan, guardados para ti</p>
        </div>
        
        <div class="row g-4">
            @foreach ($datosFavoritos as $index => $producto)
            <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="card favorite-card h-100">
                    <div class="position-relative">
                        <img class="card-img-top" src="{{asset($producto->imagen)}}" alt="{{ $producto->titulo }}" />
                        <div class="favorite-badge">
                            <i class="fas fa-heart me-1"></i>Favorito
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-center mb-3">{{ $producto->titulo }}</h5>
                        <div class="text-center mt-auto">
                            <div style="background: linear-gradient(45deg, #00d2d3, #54a0ff); color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold; display: inline-block;">
                                {{ number_format($producto->precio, 2) }} €
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-4">
                        <form action="{{route('eliminarFavorito', $producto->id)}}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id_borrar" value="{{$producto->id}}">
                            <button class="btn btn-remove-favorite" type="submit">
                                <i class="fas fa-heart-broken me-2"></i>Eliminar
                            </button>
                        </form>
                        <a class="btn btn-view-product" href="{{ route('mostrarProductoUnico', $producto->id) }}">
                            <i class="fas fa-eye me-2"></i>Ver
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="empty-favorites">
            <i class="fas fa-heart-broken fa-4x mb-4" style="opacity: 0.6;"></i>
            <h3 class="mb-3">No tienes favoritos aún</h3>
            <p class="mb-4 fs-5">¡Explora nuestros productos y añade tus favoritos para encontrarlos fácilmente!</p>
            <a href="{{ route('comprar') }}" class="btn" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 15px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                <i class="fas fa-shopping-bag me-2"></i>Explorar Productos
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