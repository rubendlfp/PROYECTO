 {{--
===========================================
VISTA: Carrito de Compras
===========================================
Propósito: Mostrar productos añadidos al carrito con opciones de gestión
Acceso: Usuarios autenticados
Funcionalidad: Ver productos, actualizar cantidades, eliminar items, proceder al pago
Ruta: /carrito
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === SECCIÓN HERO === */
/* Estilos coherentes con la página principal */
.hero-section {
    /* Gradiente púrpura de encabezado */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 0;
}

/* === SECCIÓN DEL CARRITO === */
.cart-section {
    /* Gradiente colorido de fondo */
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 20%, #667eea 100%);
    /* Altura mínima */
    min-height: 80vh;
    padding: 4rem 0;
}

/* === CONTENEDOR DEL CARRITO === */
.cart-container {
    /* Fondo blanco semi-transparente */
    background: rgba(255, 255, 255, 0.95);
    /* Efecto de desenfoque del fondo */
    backdrop-filter: blur(10px);
    border-radius: 20px;
    /* Sombra pronunciada */
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    padding: 0;
}

/* === ENCABEZADO DEL CARRITO === */
.cart-header {
    /* Gradiente púrpura */
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 2rem;
    text-align: center;
}

.cart-content {
    padding: 2rem;
}

/* === TABLA DEL CARRITO === */
.cart-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.cart-table thead {
    /* Encabezado con gradiente */
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
}

.cart-table th {
    padding: 1rem;
    border: none;
    font-weight: 600;
}

.cart-table td {
    padding: 1.5rem 1rem;
    border: none;
    /* Alineación vertical centrada */
    vertical-align: middle;
    /* Línea separadora entre filas */
    border-bottom: 1px solid #eee;
}

/* === IMAGEN DEL PRODUCTO === */
.product-image {
    width: 80px;
    height: 80px;
    /* Recorte proporcional */
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* === INFORMACIÓN DEL PRODUCTO === */
.product-title {
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.product-description {
    color: #666;
    font-size: 0.9rem;
}

/* === PRECIO === */
.price-display {
    font-size: 1.1rem;
    font-weight: bold;
    /* Color púrpura para precio */
    color: #667eea;
}

/* === INPUT DE CANTIDAD === */
.quantity-input {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    text-align: center;
    font-weight: bold;
    transition: all 0.3s ease;
}

.quantity-input:focus {
    /* Borde púrpura al enfocar */
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* === BOTÓN ACTUALIZAR === */
.btn-update {
    /* Gradiente azul */
    background: linear-gradient(45deg, #54a0ff, #2e86de);
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 10px;
    transition: all 0.3s ease;
    margin-right: 5px;
}

.btn-update:hover {
    /* Gradiente invertido al hover */
    background: linear-gradient(45deg, #2e86de, #54a0ff);
    /* Efecto de elevación */
    transform: translateY(-2px);
    color: white;
}

/* === BOTÓN ELIMINAR === */
.btn-remove {
    /* Gradiente rojo */
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-remove:hover {
    /* Gradiente invertido al hover */
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    transform: translateY(-2px);
    color: white;
}

/* === SECCIÓN DE TOTAL === */
.total-section {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* === MONTO TOTAL === */
.total-amount {
    /* Texto grande y destacado */
    font-size: 2.5rem;
    font-weight: bold;
    /* Gradiente aplicado al texto */
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
}

/* === BOTÓN PAGAR === */
.btn-pay {
    /* Gradiente rojo/naranja */
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    color: white;
    /* Botón grande y llamativo */
    padding: 15px 40px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    opacity: 1;
}

.btn-pay:hover {
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    /* Se eleva al hover */
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    color: white;
    opacity: 1;
}

/* === BOTÓN CONTINUAR COMPRANDO === */
.btn-continue {
    /* Gradiente púrpura */
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    opacity: 1;
}

.btn-continue:hover {
    background: linear-gradient(45deg, #764ba2, #667eea);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
    opacity: 1;
}

/* === CARRITO VACÍO === */
.empty-cart {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    color: #333;
}

/* === BREADCRUMB PERSONALIZADO === */
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

{{-- === SECCIÓN HERO === --}}
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        {{-- Breadcrumb de navegación --}}
        <nav class="breadcrumb-custom">
            <a href="{{ route('principal') }}">Inicio</a>
            <span class="mx-2">/</span>
            <span>Carrito de Compras</span>
        </nav>
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-shopping-cart me-3"></i>MI CARRITO
            </h1>
            <p class="lead mb-0">Revisa tus productos antes de finalizar la compra</p>
        </div>
    </div>
</section>

{{-- === SECCIÓN DEL CARRITO === --}}
<!-- Cart Section -->
<section class="cart-section">
    <div class="container">
        {{-- Condicional: mostrar carrito o mensaje de vacío --}}
        @if(count($datosCarrito) > 0)
        <div class="cart-container">
            {{-- Encabezado con contador de productos --}}
            <div class="cart-header">
                <h3 class="mb-0"><i class="fas fa-list me-2"></i>Productos en tu carrito ({{ count($datosCarrito) }})</h3>
            </div>
            
            <div class="cart-content">
                <div class="table-responsive">
                    {{-- === TABLA DE PRODUCTOS === --}}
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th style="width:50%">Producto</th>
                                <th style="width:15%">Precio</th>
                                <th style="width:15%">Cantidad</th>
                                <th style="width:20%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Itera sobre cada producto en el carrito --}}
                            @foreach ($datosCarrito as $item)
                            <tr>
                                {{-- === COLUMNA PRODUCTO === --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- Imagen del producto --}}
                                        <img src="{{asset($item->producto->imagen)}}" alt="{{ $item->producto->titulo }}" class="product-image me-3">
                                        <div>
                                            {{-- Título del producto --}}
                                            <div class="product-title">{{ $item->producto->titulo }}</div>
                                            {{-- Descripción limitada a 60 caracteres --}}
                                            <div class="product-description">{{ Str::limit($item->producto->descripcion, 60) }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- === COLUMNA PRECIO === --}}
                                <td>
                                    {{-- Precio total = precio unitario × cantidad --}}
                                    <div class="price-display">{{ number_format($item->producto->precio * $item->cantidad, 2) }} €</div>
                                    {{-- Precio unitario --}}
                                    <small class="text-muted">{{ number_format($item->producto->precio, 2) }} € c/u</small>
                                </td>
                                {{-- === COLUMNA CANTIDAD === --}}
                                <td>
                                    {{-- Formulario para cambiar cantidad --}}
                                    <form action="{{route('actualizarCantidad', $item->id)}}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        {{-- Input numérico con valor actual --}}
                                        <input type="number" name="cantidad" class="form-control quantity-input" 
                                               value="{{$item->cantidad}}" min="1" style="width: 80px;">
                                    </form>
                                </td>
                                {{-- === COLUMNA ACCIONES === --}}
                                <td>
                                    {{-- Botón Actualizar cantidad --}}
                                    <form action="{{route('actualizarCantidad', $item->id)}}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="cantidad" value="{{$item->cantidad}}">
                                        <button class="btn btn-update" type="submit" title="Actualizar">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                    {{-- Botón Eliminar producto --}}
                                    <form action="{{ route('eliminarProdCarrito')}}" method="GET" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id_borrar" value="{{$item->id}}">
                                        <button class="btn btn-remove" type="submit" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- === SECCIÓN DE TOTAL === --}}
        <!-- Total Section -->
        <div class="total-section">
            <h3 class="mb-3">Resumen del Pedido</h3>
            <div class="row">
                <div class="col-md-6">
                    {{-- Número de productos --}}
                    <p><i class="fas fa-box me-2"></i><strong>Productos:</strong> {{ count($datosCarrito) }}</p>
                    {{-- Envío gratuito --}}
                    <p><i class="fas fa-shipping-fast me-2"></i><strong>Envío:</strong> Gratis</p>
                </div>
                <div class="col-md-6">
                    {{-- Precio total formateado con 2 decimales --}}
                    <div class="total-amount">Total: {{ number_format($precioTotal, 2) }} €</div>
                </div>
            </div>
            
            {{-- Botones de acción --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                {{-- Botón para continuar comprando --}}
                <a href="{{ route('comprar')}}" class="btn btn-continue">
                    <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                </a>
                {{-- Botón para proceder al pago (pasa el total como parámetro) --}}
                <a href="{{ route('pagar', $precioTotal)}}" class="btn btn-pay">
                    <i class="fas fa-credit-card me-2"></i>PROCEDER AL PAGO
                </a>
            </div>
        </div>
        @else
        {{-- === CARRITO VACÍO === --}}
        <!-- Empty Cart -->
        <div class="empty-cart">
            {{-- Ícono grande de carrito --}}
            <i class="fas fa-shopping-cart fa-4x mb-4 text-muted"></i>
            <h3 class="mb-3">Tu carrito está vacío</h3>
            <p class="mb-4 fs-5">¡Añade algunos productos increíbles a tu carrito!</p>
            {{-- Botón para explorar productos --}}
            <a href="{{ route('comprar') }}" class="btn btn-continue">
                <i class="fas fa-shopping-bag me-2"></i>Explorar Productos
            </a>
        </div>
        @endif
    </div>
</section>

@endsection