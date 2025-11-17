@extends('index')

@section('contenido_principal')
<style>
.pedido-card {
    border-radius: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.pedido-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.estado-badge {
    font-size: 0.9em;
    padding: 0.4em 0.8em;
}

.precio-total {
    font-size: 1.2em;
    font-weight: bold;
}

.table th {
    border-top: none;
    background-color: #f8f9fa;
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

<div style="height: 20px;"></div>

<div class="container-fluid">
    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-receipt me-2"></i>
                @if(auth()->user()->tipo_usuario == 1)
                    Administrar Pedidos del Sistema
                @else
                    Mis Pedidos
                @endif
            </h2>
            <p class="text-muted">
                @if(auth()->user()->tipo_usuario == 1)
                    Visualiza y gestiona todos los pedidos realizados por los usuarios
                @else
                    Consulta el historial de tus pedidos realizados
                @endif
            </p>
        </div>
    </div>

    <div class="mb-3">
        <button class="btn btn-info" onclick="location.reload()">
            <i class="fa-solid fa-refresh me-1"></i>Actualizar
        </button>
        
        <!-- Estadísticas rápidas -->
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                        <h4>{{ count($pedidos) }}</h4>
                        <small>Total Pedidos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-euro-sign fa-2x mb-2"></i>
                        <h4>{{ number_format($pedidos->sum('precio_total'), 2) }}€</h4>
                        <small>Facturación Total</small>
                    </div>
                </div>
            </div>
            @if(auth()->user()->tipo_usuario == 1)
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h4>{{ $pedidos->unique('id_user')->count() }}</h4>
                        <small>Clientes Únicos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <h4>{{ number_format($pedidos->avg('precio_total'), 2) }}€</h4>
                        <small>Ticket Medio</small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col"># Pedido</th>
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
            @forelse ($pedidos as $pedido)
            <tr>
                <td>
                    <strong class="text-primary">#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </td>
                @if(auth()->user()->tipo_usuario == 1)
                    <td>
                        <div>
                            <strong>{{ $pedido->user->name ?? 'Usuario eliminado' }}</strong>
                            <br>
                            <small class="text-muted">{{ $pedido->user->email ?? 'N/A' }}</small>
                        </div>
                    </td>
                @endif
                <td>
                    <span class="precio-total text-success">{{ number_format($pedido->precio_total, 2) }} €</span>
                </td>
                <td>
                    <i class="fas fa-flag me-1"></i>{{ $pedido->pais }}
                </td>
                <td>
                    <i class="fas fa-city me-1"></i>{{ $pedido->ciudad }}
                </td>
                <td>
                    <i class="fas fa-map-marker-alt me-1"></i>
                    <span title="{{ $pedido->direccion }}">
                        {{ Str::limit($pedido->direccion, 30) }}
                    </span>
                </td>
                <td>
                    <i class="fas fa-calendar me-1"></i>
                    {{ $pedido->created_at->format('d/m/Y') }}
                    <br>
                    <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                </td>
                <td>
                    <span class="badge bg-success estado-badge">
                        <i class="fas fa-check me-1"></i>Completado
                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('verDetallePedido', $pedido->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->tipo_usuario == 1 ? '9' : '8' }}" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <h5>No hay pedidos disponibles</h5>
                        <p>
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

<script>
// Funcionalidad adicional
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips para direcciones largas
    const addressCells = document.querySelectorAll('[title]');
    addressCells.forEach(cell => {
        new bootstrap.Tooltip(cell);
    });
});
</script>

@endsection
