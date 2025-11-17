{{--
===========================================
VISTA: Detalle de Pedido (Administración)
===========================================
Propósito: Mostrar información completa de un pedido específico
Acceso: Administradores y usuarios autenticados
Funcionalidad: Visualización detallada de pedidos con información de envío y facturación
Ruta: /administrar/pedido/{id}
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === HEADER DEL PEDIDO === */
.pedido-header {
    /* Gradiente púrpura moderno */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* Esquinas redondeadas */
    border-radius: 15px;
    color: white;
    /* Espaciado interno generoso */
    padding: 2rem;
    margin-bottom: 2rem;
}

/* === TARJETAS DE INFORMACIÓN === */
.info-card {
    /* Esquinas redondeadas para diseño moderno */
    border-radius: 10px;
    border: none;
    /* Sombra sutil para profundidad */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    /* Transición suave para hover */
    transition: transform 0.2s;
}

.info-card:hover {
    /* Efecto de elevación al pasar el cursor */
    transform: translateY(-2px);
}

/* === ETIQUETAS Y VALORES === */
.info-label {
    /* Etiquetas en negrita */
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9em;
    /* Texto en mayúsculas para etiquetas */
    text-transform: uppercase;
    /* Espaciado entre letras para legibilidad */
    letter-spacing: 0.5px;
}

.info-value {
    /* Valores con tamaño destacado */
    font-size: 1.1em;
    color: #212529;
    margin-top: 0.3rem;
}

/* === PRECIO TOTAL === */
.precio-total {
    /* Precio grande y destacado */
    font-size: 2rem;
    font-weight: bold;
    /* Color verde para indicar éxito/pago */
    color: #28a745;
}

/* === BADGE DE ESTADO === */
.status-badge {
    font-size: 1rem;
    /* Espaciado interno del badge */
    padding: 0.5rem 1rem;
    /* Badge completamente redondeado */
    border-radius: 25px;
}
</style>

{{-- Espaciador superior --}}
<div style="height: 20px;"></div>

<div class="container-fluid">
    {{-- === ENCABEZADO DEL PEDIDO === --}}
    {{-- Muestra el número de pedido formateado con ceros a la izquierda --}}
    <div class="pedido-header text-center">
        <h1 class="mb-3">
            <i class="fas fa-receipt me-3"></i>
            {{-- str_pad formatea el ID con 6 dígitos (ej: 000001) --}}
            Pedido #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
        </h1>
        <p class="lead mb-0">Detalles completos del pedido</p>
    </div>

    {{-- === BOTONES DE NAVEGACIÓN === --}}
    <div class="mb-4">
        {{-- Botón para volver al listado de pedidos --}}
        <a href="{{ route('administrarPedidos') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Pedidos
        </a>
        {{-- Botón para imprimir el pedido (activa window.print()) --}}
        <button class="btn btn-info ms-2" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Imprimir
        </button>
    </div>

    <div class="row g-4">
        {{-- === INFORMACIÓN DEL CLIENTE === --}}
        {{-- Solo visible para administradores (tipo_usuario == 1) --}}
        @if(auth()->user()->tipo_usuario == 1)
        <div class="col-md-6">
            <div class="card info-card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Información del Cliente
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Nombre del cliente --}}
                    <div class="mb-3">
                        <div class="info-label">Nombre del Cliente</div>
                        <div class="info-value">
                            {{-- Operador ?? para manejar usuarios eliminados --}}
                            <strong>{{ $pedido->user->name ?? 'Usuario eliminado' }}</strong>
                        </div>
                    </div>
                    {{-- Email del cliente --}}
                    <div class="mb-3">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <i class="fas fa-envelope me-2"></i>{{ $pedido->user->email ?? 'N/A' }}
                        </div>
                    </div>
                    {{-- ID único del usuario --}}
                    <div class="mb-3">
                        <div class="info-label">ID de Usuario</div>
                        <div class="info-value">
                            <span class="badge bg-info">#{{ $pedido->id_user }}</span>
                        </div>
                    </div>
                    {{-- Fecha de registro del usuario (solo si existe) --}}
                    @if($pedido->user)
                    <div class="mb-3">
                        <div class="info-label">Fecha de Registro</div>
                        <div class="info-value">
                            <i class="fas fa-calendar-plus me-2"></i>
                            {{-- Formato de fecha personalizado --}}
                            {{ $pedido->user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- === INFORMACIÓN DEL PEDIDO === --}}
        {{-- Tarjeta con detalles generales del pedido --}}
        <div class="col-md-6">
            <div class="card info-card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag me-2"></i>Detalles del Pedido
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Número de pedido formateado --}}
                    <div class="mb-3">
                        <div class="info-label">Número de Pedido</div>
                        <div class="info-value">
                            <strong>#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </div>
                    {{-- Fecha y hora del pedido --}}
                    <div class="mb-3">
                        <div class="info-label">Fecha del Pedido</div>
                        <div class="info-value">
                            <i class="fas fa-calendar me-2"></i>
                            {{-- Formato: 17/11/2025 14:30 --}}
                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                            {{-- diffForHumans muestra tiempo relativo (ej: "hace 2 horas") --}}
                            <small class="text-muted">({{ $pedido->created_at->diffForHumans() }})</small>
                        </div>
                    </div>
                    {{-- Estado del pedido --}}
                    <div class="mb-3">
                        <div class="info-label">Estado</div>
                        <div class="info-value">
                            <span class="badge bg-success status-badge">
                                <i class="fas fa-check me-2"></i>Completado
                            </span>
                        </div>
                    </div>
                    {{-- Precio total del pedido --}}
                    <div class="mb-3">
                        <div class="info-label">Precio Total</div>
                        <div class="precio-total">
                            {{-- number_format para mostrar 2 decimales --}}
                            {{ number_format($pedido->precio_total, 2) }} €
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === INFORMACIÓN DE ENVÍO === --}}
    {{-- Datos de dirección de entrega del pedido --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i>Información de Envío
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Desglose de datos de envío en 3 columnas --}}
                    <div class="row">
                        {{-- País de destino --}}
                        <div class="col-md-4">
                            <div class="info-label">País</div>
                            <div class="info-value">
                                <i class="fas fa-flag me-2"></i>
                                <strong>{{ $pedido->pais }}</strong>
                            </div>
                        </div>
                        {{-- Ciudad de destino --}}
                        <div class="col-md-4">
                            <div class="info-label">Ciudad</div>
                            <div class="info-value">
                                <i class="fas fa-city me-2"></i>
                                <strong>{{ $pedido->ciudad }}</strong>
                            </div>
                        </div>
                        {{-- Dirección completa --}}
                        <div class="col-md-4">
                            <div class="info-label">Dirección Completa</div>
                            <div class="info-value">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <strong>{{ $pedido->direccion }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Visualización destacada de la dirección completa --}}
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="mb-3">
                            <i class="fas fa-map me-2"></i>Dirección de Envío Completa
                        </h6>
                        {{-- Alert informativo con icono de ubicación --}}
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

    {{-- === RESUMEN FINANCIERO === --}}
    {{-- Desglose de costes del pedido (subtotal, IVA, envío, total) --}}
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
                        {{-- Desglose de costes en tabla --}}
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="info-label">Subtotal:</td>
                                    {{-- Cálculo: precio_total * 0.79 (base sin IVA) --}}
                                    <td class="text-end info-value">{{ number_format($pedido->precio_total * 0.79, 2) }} €</td>
                                </tr>
                                <tr>
                                    <td class="info-label">IVA (21%):</td>
                                    {{-- Cálculo: precio_total * 0.21 (impuesto) --}}
                                    <td class="text-end info-value">{{ number_format($pedido->precio_total * 0.21, 2) }} €</td>
                                </tr>
                                <tr>
                                    <td class="info-label">Envío:</td>
                                    {{-- Envío gratuito --}}
                                    <td class="text-end info-value">0.00 €</td>
                                </tr>
                            </table>
                        </div>
                        {{-- Total destacado en tarjeta verde --}}
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

    {{-- === INFORMACIÓN ADICIONAL === --}}
    {{-- Método de pago, estado de entrega y notas --}}
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
                        {{-- Método de pago utilizado --}}
                        <div class="col-md-6">
                            <div class="info-label">Método de Pago</div>
                            <div class="info-value">
                                <i class="fas fa-credit-card me-2"></i>
                                Saldo de Cuenta
                            </div>
                        </div>
                        {{-- Estado de la entrega --}}
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
                    
                    {{-- Notas y observaciones del pedido --}}
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

{{-- === ESTILOS PARA IMPRESIÓN === --}}
{{-- Oculta elementos innecesarios al imprimir --}}
<style media="print">
    /* Ocultar botones y encabezados al imprimir */
    .btn, .card-header { 
        display: none !important; 
    }
    /* Forzar color de fondo en impresión */
    .pedido-header {
        background: #333 !important;
        /* Asegura que los colores se impriman correctamente */
        -webkit-print-color-adjust: exact;
    }
</style>

@endsection
