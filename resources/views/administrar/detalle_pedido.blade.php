@extends('index')

@section('contenido_principal')
<style>
.pedido-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
}

.info-card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.info-card:hover {
    transform: translateY(-2px);
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1.1em;
    color: #212529;
    margin-top: 0.3rem;
}

.precio-total {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
}

.status-badge {
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
}
</style>

<div style="height: 20px;"></div>

<div class="container-fluid">
    <!-- Header del pedido -->
    <div class="pedido-header text-center">
        <h1 class="mb-3">
            <i class="fas fa-receipt me-3"></i>
            Pedido #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
        </h1>
        <p class="lead mb-0">Detalles completos del pedido</p>
    </div>

    <!-- Botones de navegación -->
    <div class="mb-4">
        <a href="{{ route('administrarPedidos') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Pedidos
        </a>
        <button class="btn btn-info ms-2" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Imprimir
        </button>
    </div>

    <div class="row g-4">
        <!-- Información del Cliente -->
        @if(auth()->user()->tipo_usuario == 1)
        <div class="col-md-6">
            <div class="card info-card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Información del Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Nombre del Cliente</div>
                        <div class="info-value">
                            <strong>{{ $pedido->user->name ?? 'Usuario eliminado' }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <i class="fas fa-envelope me-2"></i>{{ $pedido->user->email ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">ID de Usuario</div>
                        <div class="info-value">
                            <span class="badge bg-info">#{{ $pedido->id_user }}</span>
                        </div>
                    </div>
                    @if($pedido->user)
                    <div class="mb-3">
                        <div class="info-label">Fecha de Registro</div>
                        <div class="info-value">
                            <i class="fas fa-calendar-plus me-2"></i>
                            {{ $pedido->user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Información del Pedido -->
        <div class="col-md-6">
            <div class="card info-card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag me-2"></i>Detalles del Pedido
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Número de Pedido</div>
                        <div class="info-value">
                            <strong>#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Fecha del Pedido</div>
                        <div class="info-value">
                            <i class="fas fa-calendar me-2"></i>
                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                            <small class="text-muted">({{ $pedido->created_at->diffForHumans() }})</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Estado</div>
                        <div class="info-value">
                            <span class="badge bg-success status-badge">
                                <i class="fas fa-check me-2"></i>Completado
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Precio Total</div>
                        <div class="precio-total">
                            {{ number_format($pedido->precio_total, 2) }} €
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Envío -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i>Información de Envío
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-label">País</div>
                            <div class="info-value">
                                <i class="fas fa-flag me-2"></i>
                                <strong>{{ $pedido->pais }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Ciudad</div>
                            <div class="info-value">
                                <i class="fas fa-city me-2"></i>
                                <strong>{{ $pedido->ciudad }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Dirección Completa</div>
                            <div class="info-value">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <strong>{{ $pedido->direccion }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa conceptual (simulado) -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="mb-3">
                            <i class="fas fa-map me-2"></i>Dirección de Envío Completa
                        </h6>
                        <div class="alert alert-info mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-location-arrow fa-2x me-3 text-primary"></i>
                                <div>
                                    <strong>{{ $pedido->direccion }}</strong><br>
                                    {{ $pedido->ciudad }}, {{ $pedido->pais }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen Financiero -->
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card info-card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calculator me-2"></i>Resumen Financiero
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="info-label">Subtotal:</td>
                                    <td class="text-end info-value">{{ number_format($pedido->precio_total * 0.79, 2) }} €</td>
                                </tr>
                                <tr>
                                    <td class="info-label">IVA (21%):</td>
                                    <td class="text-end info-value">{{ number_format($pedido->precio_total * 0.21, 2) }} €</td>
                                </tr>
                                <tr>
                                    <td class="info-label">Envío:</td>
                                    <td class="text-end info-value">0.00 €</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center p-4 bg-success text-white rounded">
                                <div class="info-label text-white-50">TOTAL PAGADO</div>
                                <div class="precio-total text-white">
                                    {{ number_format($pedido->precio_total, 2) }} €
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información Adicional
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Método de Pago</div>
                            <div class="info-value">
                                <i class="fas fa-credit-card me-2"></i>
                                Saldo de Cuenta
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Estado de Entrega</div>
                            <div class="info-value">
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Entregado
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="info-label">Notas del Pedido</div>
                            <div class="info-value">
                                <p class="text-muted mb-0">
                                    Pedido procesado automáticamente. Entrega realizada en la dirección especificada.
                                    Para cualquier consulta, contacte con el servicio de atención al cliente.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    .btn, .card-header { 
        display: none !important; 
    }
    .pedido-header {
        background: #333 !important;
        -webkit-print-color-adjust: exact;
    }
</style>

@endsection
