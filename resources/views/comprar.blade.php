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

.filters-section {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 2rem 0;
    margin-bottom: 3rem;
}

.product-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.product-card img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover img {
    transform: scale(1.05);
}

.btn-filters {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.btn-filters:hover {
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    color: white;
}

.btn-view-product {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-product:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    color: white;
}

.price-tag {
    background: linear-gradient(45deg, #00d2d3, #54a0ff);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.category-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255,255,255,0.9);
    color: #333;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.search-container {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
}

.search-input, .search-select {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 15px;
}

.btn-search {
    background: linear-gradient(45deg, #3742fa, #2f3542);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-search:hover {
    background: linear-gradient(45deg, #2f3542, #3742fa);
    transform: translateY(-2px);
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

.products-grid {
    margin-top: 3rem;
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
    color: #6c757d;
    font-size: 1.1rem;
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">{{ $categoria ?? 'PRODUCTOS' }}</h1>
            <p class="lead mb-0">Encuentra lo que buscas entre una gran variedad de productos deportivos</p>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="filters-section">
    <div class="container">
        <div class="text-center mb-4">
            <button class="btn btn-filters" data-bs-toggle="collapse" href="#filtros" role="button"
                aria-expanded="false" aria-controls="filtros">
                <i class="fas fa-filter me-2"></i>FILTROS AVANZADOS
            </button>
        </div>
        
        <div class="collapse" id="filtros">
            <div class="search-container">
                <form method="GET" action="{{ route('comprar') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="text" name="search" class="form-control search-input" 
                                   placeholder="🔍 Buscar productos..." value="{{ request('search') }}">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <select name="categoria" class="form-select search-select">
                                <option value="">📁 Todas las categorías</option>
                                <option value="Ropa" {{ request('categoria') == 'Ropa' ? 'selected' : '' }}>👕 Ropa</option>
                                <option value="Calzado" {{ request('categoria') == 'Calzado' ? 'selected' : '' }}>👟 Calzado</option>
                                <option value="Complementos" {{ request('categoria') == 'Complementos' ? 'selected' : '' }}>💎 Complementos</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <select name="color" class="form-select search-select">
                                <option value="">⚧ Todos los géneros</option>
                                <option value="masculino" {{ request('color') == 'masculino' ? 'selected' : '' }}>👨 Masculino</option>
                                <option value="femenino" {{ request('color') == 'femenino' ? 'selected' : '' }}>👩 Femenino</option>
                                <option value="unisex" {{ request('color') == 'unisex' ? 'selected' : '' }}>👫 Unisex</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <select name="talla" class="form-select search-select">
                                <option value="">🏷️ Todas las marcas</option>
                                <option value="Nike" {{ request('talla') == 'Nike' ? 'selected' : '' }}>Nike</option>
                                <option value="Adidas" {{ request('talla') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                                <option value="Puma" {{ request('talla') == 'Puma' ? 'selected' : '' }}>Puma</option>
                                <option value="Reebok" {{ request('talla') == 'Reebok' ? 'selected' : '' }}>Reebok</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-search me-3">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                        <button type="button" class="btn btn-outline-light" onclick="clearFilters()">
                            <i class="fas fa-eraser me-2"></i>Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Nuestros Productos</h2>
            <p>Descubre nuestra selección de productos deportivos de alta calidad</p>
        </div>
        
        <div class="products-grid">
            <div class="row g-4">
                @forelse ($datosProductos as $index => $producto)
                <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img class="card-img-top" src="{{asset($producto->imagen)}}" alt="{{ $producto->titulo }}" />
                            <div class="category-badge">{{ ucfirst($producto->tipo) }}</div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-center mb-3">{{ $producto->titulo }}</h5>
                            <div class="text-center mt-auto">
                                <div class="price-tag">{{ number_format($producto->precio, 2) }} €</div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <a class="btn btn-view-product" href="{{ route('mostrarProductoUnico', $producto->id) }}">
                                <i class="fas fa-eye me-2"></i>Ver Producto
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No se encontraron productos</h3>
                        <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
                        <a href="{{ route('comprar') }}" class="btn btn-view-product">
                            <i class="fas fa-arrow-left me-2"></i>Ver Todos los Productos
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<script>
function clearFilters() {
    window.location.href = "{{ route('comprar') }}";
}

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