{{--
===========================================
VISTA: Catálogo de Productos / Comprar
===========================================
Propósito: Mostrar catálogo de productos con filtros avanzados de búsqueda
Acceso: Todos los usuarios (autenticados y no autenticados)
Funcionalidad: Búsqueda y filtrado por categoría, género, marca; visualización de productos
Ruta: /comprar
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === SECCIÓN HERO === */
/* Encabezado con gradiente púrpura coherente con el diseño general */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 0;
}

/* === SECCIÓN DE FILTROS === */
/* Área de filtros con gradiente rosa/rojo */
.filters-section {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 2rem 0;
    margin-bottom: 3rem;
}

/* === TARJETA DE PRODUCTO === */
/* Tarjeta con bordes redondeados y efectos de elevación */
.product-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    /* Transiciones suaves para hover */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Efecto de elevación al pasar el mouse */
.product-card:hover {
    /* Se eleva 10px */
    transform: translateY(-10px);
    /* Sombra más pronunciada */
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

/* Imagen del producto con altura fija */
.product-card img {
    height: 250px;
    /* Recorte proporcional */
    object-fit: cover;
    transition: transform 0.3s ease;
}

/* Zoom de imagen al hover */
.product-card:hover img {
    transform: scale(1.05);
}

/* === BOTÓN DE FILTROS === */
/* Botón para expandir/colapsar filtros con gradiente rojo */
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

/* Efecto hover con gradiente invertido */
.btn-filters:hover {
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    color: white;
}

/* === BOTÓN VER PRODUCTO === */
/* Botón para navegar al detalle del producto */
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

/* === ETIQUETA DE PRECIO === */
/* Badge con gradiente azul/cyan para mostrar el precio */
.price-tag {
    background: linear-gradient(45deg, #00d2d3, #54a0ff);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

/* === BADGE DE CATEGORÍA === */
/* Badge posicionado en la esquina superior derecha de la tarjeta */
.category-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    /* Fondo blanco semi-transparente */
    background: rgba(255,255,255,0.9);
    color: #333;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* === CONTENEDOR DE BÚSQUEDA === */
/* Contenedor para los filtros con efecto de glassmorphism */
.search-container {
    background: rgba(255,255,255,0.1);
    /* Efecto de desenfoque del fondo */
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
}

/* === INPUTS Y SELECTS === */
/* Estilos para campos de búsqueda y filtros */
.search-input, .search-select {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 15px;
}

/* === BOTÓN BUSCAR === */
/* Botón para ejecutar búsqueda con gradiente azul oscuro */
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

/* === ANIMACIÓN FADE IN === */
/* Clase para animar la aparición de las tarjetas */
.animate-fade-in {
    animation: fadeInUp 0.6s ease forwards;
}

/* Animación de aparición desde abajo con fade */
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

/* === GRID DE PRODUCTOS === */
.products-grid {
    margin-top: 3rem;
}

/* === TÍTULO DE SECCIÓN === */
.section-title {
    text-align: center;
    margin-bottom: 3rem;
}

/* Título con gradiente aplicado al texto */
.section-title h2 {
    font-size: 2.5rem;
    font-weight: bold;
    /* Gradiente púrpura en el texto */
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

{{-- === SECCIÓN HERO === --}}
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            {{-- Título dinámico: muestra categoría si existe, sino "PRODUCTOS" --}}
            <h1 class="display-4 fw-bold mb-3">{{ $categoria ?? 'PRODUCTOS' }}</h1>
            <p class="lead mb-0">Encuentra lo que buscas entre una gran variedad de productos deportivos</p>
        </div>
    </div>
</section>

{{-- === SECCIÓN DE FILTROS === --}}
<!-- Filters Section -->
<section class="filters-section">
    <div class="container">
        {{-- Botón para expandir/colapsar filtros usando Bootstrap collapse --}}
        <div class="text-center mb-4">
            <button class="btn btn-filters" data-bs-toggle="collapse" href="#filtros" role="button"
                aria-expanded="false" aria-controls="filtros">
                <i class="fas fa-filter me-2"></i>FILTROS AVANZADOS
            </button>
        </div>
        
        {{-- Contenedor colapsable de filtros --}}
        <div class="collapse" id="filtros">
            <div class="search-container">
                {{-- Formulario GET para mantener filtros en URL --}}
                <form method="GET" action="{{ route('comprar') }}">
                    <div class="row">
                        {{-- === BÚSQUEDA POR TEXTO === --}}
                        <div class="col-md-3 mb-3">
                            {{-- Input de búsqueda que mantiene el valor con request('search') --}}
                            <input type="text" name="search" class="form-control search-input" 
                                   placeholder="🔍 Buscar productos..." value="{{ request('search') }}">
                        </div>
                        
                        {{-- === FILTRO POR CATEGORÍA === --}}
                        <div class="col-md-3 mb-3">
                            <select name="categoria" class="form-select search-select">
                                <option value="">📁 Todas las categorías</option>
                                {{-- Operador ternario para mantener selección --}}
                                <option value="Ropa" {{ request('categoria') == 'Ropa' ? 'selected' : '' }}>👕 Ropa</option>
                                <option value="Calzado" {{ request('categoria') == 'Calzado' ? 'selected' : '' }}>👟 Calzado</option>
                                <option value="Complementos" {{ request('categoria') == 'Complementos' ? 'selected' : '' }}>💎 Complementos</option>
                            </select>
                        </div>
                        
                        {{-- === FILTRO POR GÉNERO === --}}
                        {{-- Nota: el campo se llama 'color' pero filtra por género --}}
                        <div class="col-md-3 mb-3">
                            <select name="color" class="form-select search-select">
                                <option value="">⚧ Todos los géneros</option>
                                <option value="masculino" {{ request('color') == 'masculino' ? 'selected' : '' }}>👨 Masculino</option>
                                <option value="femenino" {{ request('color') == 'femenino' ? 'selected' : '' }}>👩 Femenino</option>
                                <option value="unisex" {{ request('color') == 'unisex' ? 'selected' : '' }}>👫 Unisex</option>
                            </select>
                        </div>
                        
                        {{-- === FILTRO POR MARCA === --}}
                        {{-- Nota: el campo se llama 'talla' pero filtra por marca --}}
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
                    
                    {{-- Botones de acción --}}
                    <div class="text-center">
                        {{-- Botón para ejecutar búsqueda --}}
                        <button type="submit" class="btn btn-search me-3">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                        {{-- Botón para limpiar filtros (llama función JS) --}}
                        <button type="button" class="btn btn-outline-light" onclick="clearFilters()">
                            <i class="fas fa-eraser me-2"></i>Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- === SECCIÓN DE PRODUCTOS === --}}
<!-- Products Section -->
<section class="py-5">
    <div class="container">
        {{-- Título de la sección --}}
        <div class="section-title">
            <h2>Nuestros Productos</h2>
            <p>Descubre nuestra selección de productos deportivos de alta calidad</p>
        </div>
        
        <div class="products-grid">
            {{-- Grid responsivo Bootstrap: 4 columnas lg, 2 columnas md --}}
            <div class="row g-4">
                {{-- === BUCLE DE PRODUCTOS === --}}
                {{-- @forelse: itera si hay productos, sino muestra @empty --}}
                @forelse ($datosProductos as $index => $producto)
                {{-- Retraso de animación basado en el índice (0.1s por tarjeta) --}}
                <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="card product-card h-100">
                        {{-- === IMAGEN Y BADGE === --}}
                        <div class="position-relative">
                            {{-- Imagen del producto usando helper asset() --}}
                            <img class="card-img-top" src="{{asset($producto->imagen)}}" alt="{{ $producto->titulo }}" />
                            {{-- Badge de categoría en esquina superior derecha --}}
                            {{-- ucfirst(): capitaliza primera letra --}}
                            <div class="category-badge">{{ ucfirst($producto->tipo) }}</div>
                        </div>
                        {{-- === CUERPO DE LA TARJETA === --}}
                        {{-- d-flex flex-column: layout flexible vertical --}}
                        <div class="card-body d-flex flex-column">
                            {{-- Título del producto --}}
                            <h5 class="card-title fw-bold text-center mb-3">{{ $producto->titulo }}</h5>
                            {{-- mt-auto: empuja el precio hacia abajo --}}
                            <div class="text-center mt-auto">
                                {{-- Precio formateado con 2 decimales usando number_format() --}}
                                <div class="price-tag">{{ number_format($producto->precio, 2) }} €</div>
                            </div>
                        </div>
                        {{-- === PIE DE TARJETA === --}}
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            {{-- Enlace al detalle del producto pasando ID como parámetro --}}
                            <a class="btn btn-view-product" href="{{ route('mostrarProductoUnico', $producto->id) }}">
                                <i class="fas fa-eye me-2"></i>Ver Producto
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                {{-- === ESTADO VACÍO === --}}
                {{-- Se muestra cuando no hay productos o no coinciden con filtros --}}
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No se encontraron productos</h3>
                        <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
                        {{-- Enlace para volver a ver todos los productos --}}
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

{{-- === JAVASCRIPT === --}}
<script>
/**
 * Función para limpiar filtros
 * Redirige a la ruta base sin parámetros GET
 */
function clearFilters() {
    window.location.href = "{{ route('comprar') }}";
}

/**
 * Animaciones para las tarjetas al cargar la página
 * Aplica transiciones escalonadas a cada tarjeta
 */
document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todas las tarjetas con animación
    const cards = document.querySelectorAll('.animate-fade-in');
    // Itera sobre cada tarjeta
    cards.forEach((card, index) => {
        // Aplica timeout basado en el índice para efecto cascada
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100); // 100ms de retraso entre tarjetas
    });
});
</script>

@endsection