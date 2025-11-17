{{--
===========================================
VISTA: Administrar Pedidos
===========================================
Propósito: Listado de pedidos del sistema con estadísticas
Acceso: Administradores ven todos los pedidos, usuarios solo los suyos
Funcionalidad: Visualización, estadísticas y acceso a detalles de pedidos
Ruta: /administrar/pedidos (admin) o /mis-pedidos (usuario)
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === TARJETAS DE PEDIDO === */
.pedido-card {
    /* Esquinas redondeadas */
    border-radius: 10px;
    /* Transiciones suaves para hover */
    transition: transform 0.2s, box-shadow 0.2s;
}

.pedido-card:hover {
    /* Efecto de elevación al pasar cursor */
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* === BADGES Y ETIQUETAS === */
.estado-badge {
    font-size: 0.9em;
    padding: 0.4em 0.8em;
}

/* === PRECIO DESTACADO === */
.precio-total {
    font-size: 1.2em;
    font-weight: bold;
}

/* === ENCABEZADOS DE TABLA === */
.table th {
    /* Sin borde superior */
    border-top: none;
    /* Fondo gris claro */
    background-color: #f8f9fa;
    font-weight: 600;
}

/* === HOVER EN FILAS === */
.table-hover tbody tr:hover {
    /* Fondo azul claro al pasar cursor */
    background-color: rgba(0,123,255,0.05);
}

/* === BOTONES PEQUEÑOS === */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

{{-- Espaciador superior --}}
<div style="height: 20px;"></div>

<div class="container-fluid">
    {{-- === MENSAJES DE FEEDBACK === --}}
    <!-- Mensajes de éxito -->
    {{-- Muestra mensaje de éxito si existe en la sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Muestra mensaje de error si existe en la sesión --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- === ENCABEZADO DE LA PÁGINA === --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-receipt me-2"></i>
                {{-- Título diferente según tipo de usuario --}}
                @if(auth()->user()->tipo_usuario == 1)
                    Administrar Pedidos del Sistema
                @else
                    Mis Pedidos
                @endif
            </h2>
            <p class="text-muted">
                {{-- Descripción diferente según tipo de usuario --}}
                @if(auth()->user()->tipo_usuario == 1)
                    Visualiza y gestiona todos los pedidos realizados por los usuarios
                @else
                    Consulta el historial de tus pedidos realizados
                @endif
            </p>
        </div>
    </div>

    {{-- === BOTÓN DE ACTUALIZAR === --}}
    <div class="mb-3">
        <button class="btn btn-info" onclick="location.reload()">
            <i class="fa-solid fa-refresh me-1"></i>Actualizar
        </button>
        
        {{-- === ESTADÍSTICAS RÁPIDAS === --}}
        <!-- Estadísticas rápidas -->
        <div class="row mt-3">
            {{-- Total de Pedidos --}}
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                        {{-- count() cuenta el número total de pedidos --}}
                        <h4>{{ count($pedidos) }}</h4>
                        <small>Total Pedidos</small>
                    </div>
                </div>
            </div>
            {{-- Facturación Total --}}
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-euro-sign fa-2x mb-2"></i>
                        {{-- sum() suma todos los precios totales --}}
                        <h4>{{ number_format($pedidos->sum('precio_total'), 2) }}€</h4>
                        <small>Facturación Total</small>
                    </div>
                </div>
            </div>
            {{-- Estadísticas adicionales solo para administradores --}}
            @if(auth()->user()->tipo_usuario == 1)
            {{-- Clientes Únicos --}}
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        {{-- unique() cuenta usuarios únicos que han hecho pedidos --}}
                        <h4>{{ $pedidos->unique('id_user')->count() }}</h4>
                        <small>Clientes Únicos</small>
                    </div>
                </div>
            </div>
            {{-- Ticket Medio --}}
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        {{-- avg() calcula el promedio de precio de pedidos --}}
                        <h4>{{ number_format($pedidos->avg('precio_total'), 2) }}€</h4>
                        <small>Ticket Medio</small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- === TABLA DE PEDIDOS === --}}
<div class="table-responsive">
    <table class="table table-hover">
        {{-- Encabezados de la tabla --}}
        <thead class="table-dark">
            <tr>
                <th scope="col"># Pedido</th>
                {{-- Columna Cliente solo visible para administradores --}}
                @if(auth()->user()->tipo_usuario == 1)
                    <th scope="col">Cliente</th>
                @endif
                <th scope="col">Precio Total</th>
                <th scope="col">País</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Dirección</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- === ITERACIÓN DE PEDIDOS === --}}
            {{-- @forelse permite mostrar contenido alternativo si está vacío --}}
            @forelse ($pedidos as $pedido)
            <tr>
                {{-- Número de pedido formateado con ceros --}}
                <td>
                    {{-- str_pad rellena con ceros a la izquierda (ej: 000001) --}}
                    <strong class="text-primary">#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </td>
                {{-- Información del cliente (solo admin) --}}
                @if(auth()->user()->tipo_usuario == 1)
                    <td>
                        <div>
                            {{-- Operador ?? para manejar usuarios eliminados --}}
                            <strong>{{ $pedido->user->name ?? 'Usuario eliminado' }}</strong>
                            <br>
                            <small class="text-muted">{{ $pedido->user->email ?? 'N/A' }}</small>
                        </div>
                    </td>
                @endif
                {{-- Precio total del pedido --}}
                <td>
                    {{-- number_format formatea con 2 decimales --}}
                    <span class="precio-total text-success">{{ number_format($pedido->precio_total, 2) }} €</span>
                </td>
                {{-- País de envío --}}
                <td>
                    <i class="fas fa-flag me-1"></i>{{ $pedido->pais }}
                </td>
                {{-- Ciudad de envío --}}
                <td>
                    <i class="fas fa-city me-1"></i>{{ $pedido->ciudad }}
                </td>
                {{-- Dirección con limitación de caracteres --}}
                <td>
                    <i class="fas fa-map-marker-alt me-1"></i>
                    {{-- title muestra tooltip con dirección completa --}}
                    <span title="{{ $pedido->direccion }}">
                        {{-- Str::limit limita a 30 caracteres y añade ... --}}
                        {{ Str::limit($pedido->direccion, 30) }}
                    </span>
                </td>
                {{-- Fecha y hora del pedido --}}
                <td>
                    <i class="fas fa-calendar me-1"></i>
                    {{-- Formato: 17/11/2025 --}}
                    {{ $pedido->created_at->format('d/m/Y') }}
                    <br>
                    {{-- Hora en formato 24h --}}
                    <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                </td>
                {{-- Estado del pedido --}}
                <td>
                    <span class="badge bg-success estado-badge">
                        <i class="fas fa-check me-1"></i>Completado
                    </span>
                </td>
                {{-- Botones de acción --}}
                <td>
                    <div class="btn-group" role="group">
                        {{-- Botón para ver detalle del pedido --}}
                        <a href="{{ route('verDetallePedido', $pedido->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                    </div>
                </td>
            </tr>
            {{-- === ESTADO VACÍO === --}}
            {{-- Se muestra si no hay pedidos --}}
            @empty
            <tr>
                {{-- Colspan dinámico: 9 columnas para admin, 8 para usuario --}}
                <td colspan="{{ auth()->user()->tipo_usuario == 1 ? '9' : '8' }}" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <h5>No hay pedidos disponibles</h5>
                        <p>
                            {{-- Mensaje diferente según tipo de usuario --}}
                            @if(auth()->user()->tipo_usuario == 1)
                                No se han realizado pedidos en el sistema aún.
                            @else
                                Aún no has realizado ningún pedido. <a href="{{ route('comprar') }}" class="text-decoration-none">¡Explora nuestros productos!</a>
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- === JAVASCRIPT === --}}
<script>
// === INICIALIZACIÓN AL CARGAR LA PÁGINA ===
// Funcionalidad adicional
document.addEventListener('DOMContentLoaded', function() {
    // === TOOLTIPS PARA DIRECCIONES LARGAS ===
    // Tooltips para direcciones largas
    // Selecciona todos los elementos con atributo title
    const addressCells = document.querySelectorAll('[title]');
    // Inicializa tooltip de Bootstrap para cada elemento
    addressCells.forEach(cell => {
        // Crea una instancia de tooltip para mostrar dirección completa
        new bootstrap.Tooltip(cell);
    });
});
</script>

@endsection
