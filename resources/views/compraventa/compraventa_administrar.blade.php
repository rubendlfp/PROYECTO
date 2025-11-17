@extends('index')

@section('contenido_principal')
<style>
/* Estilos para la página de administración de compraventa */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
}

.admin-container {
    padding: 0 1rem;
}

.alert-custom {
    border-radius: 10px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.alert-success {
    background: linear-gradient(45deg, #d4edda, #c3e6cb);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(45deg, #f8d7da, #f5c6cb);
    color: #721c24;
}

.btn-add-product {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    margin-right: 10px;
    margin-bottom: 10px;
}

.btn-add-product:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
}

.btn-refresh {
    background: linear-gradient(45deg, #17a2b8, #138496);
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
    margin-bottom: 10px;
}

.btn-refresh:hover {
    background: linear-gradient(45deg, #138496, #117a8b);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(23, 162, 184, 0.4);
    color: white;
}

.debug-info {
    background: rgba(108, 117, 125, 0.1);
    border-radius: 8px;
    padding: 0.8rem;
    margin-top: 1rem;
    border-left: 4px solid #6c757d;
}

.products-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
}

.table-header {
    background: linear-gradient(45deg, #2c3e50, #34495e);
    color: white;
}

.table-header th {
    border: none;
    padding: 1rem;
    font-weight: 600;
    vertical-align: middle;
    white-space: nowrap;
}

.products-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e9ecef;
}

.products-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
}

.products-table tbody tr:last-child {
    border-bottom: none;
}

.products-table td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
}

.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.product-title {
    font-weight: 600;
    color: #2c3e50;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.product-price {
    font-weight: 700;
    color: #667eea;
    font-size: 1.1rem;
}

.owner-info {
    text-align: center;
}

.owner-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.owner-id {
    font-size: 0.8rem;
    color: #6c757d;
}

.badge-custom {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-available {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.badge-owner {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
}

.date-info {
    font-weight: 500;
    color: #495057;
}

.actions-container {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.btn-view {
    background: linear-gradient(45deg, #17a2b8, #138496);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
}

.btn-view:hover {
    background: linear-gradient(45deg, #138496, #117a8b);
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
    color: white;
}

.btn-edit {
    background: linear-gradient(45deg, #ffc107, #e0a800);
    border: none;
    color: #212529;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    text-decoration: none;
}

.btn-edit:hover {
    background: linear-gradient(45deg, #e0a800, #d39e00);
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    color: #212529;
    text-decoration: none;
}

.btn-delete {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
}

.btn-delete:hover {
    background: linear-gradient(45deg, #c82333, #a71e2a);
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6c757d;
}

.empty-state i {
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #495057;
    margin-bottom: 1rem;
}

.empty-state .btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.empty-state .btn:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
    color: white;
}

.table-responsive-custom {
    border-radius: 15px;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .admin-header {
        padding: 1.5rem 0;
    }
    
    .admin-header h1 {
        font-size: 1.8rem;
    }
    
    .products-table {
        font-size: 0.9rem;
    }
    
    .table-header th {
        padding: 0.75rem 0.5rem;
        font-size: 0.85rem;
    }
    
    .products-table td {
        padding: 0.75rem 0.5rem;
    }
    
    .product-image {
        width: 50px;
        height: 50px;
    }
    
    .actions-container {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .btn-view, .btn-edit, .btn-delete {
        padding: 5px 10px;
        font-size: 0.8rem;
        width: 100%;
    }
    
    .product-title {
        max-width: 120px;
        font-size: 0.9rem;
    }
    
    .btn-add-product, .btn-refresh {
        width: 100%;
        justify-content: center;
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .table-header th:nth-child(1),
    .products-table td:nth-child(1) {
        width: 80px;
    }
    
    .table-header th:nth-child(7),
    .products-table td:nth-child(7) {
        width: 120px;
    }
}
</style>

<div class="admin-container">
    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-handshake me-3"></i>
                Administración de Compraventa
            </h1>
            <p class="lead mb-0">Gestiona los productos publicados por los usuarios</p>
        </div>
    </div>

    <!-- Action Buttons and Debug Info -->
    <div class="mb-4">
        <div class="d-flex flex-wrap align-items-center">
            <a href="{{ route('menuNuevoCompraventa') }}" class="btn-add-product">
                <i class="fas fa-plus me-2"></i>
                Añadir Producto
            </a>
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt me-2"></i>
                Actualizar
            </button>
        </div>
        
        <!-- Información de depuración -->
        <div class="debug-info">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Usuario:</strong> {{ auth()->user()->name ?? 'No autenticado' }} | 
                <strong>Tipo:</strong> {{ auth()->user()->tipo_usuario ?? 'No definido' }} | 
                <strong>Productos encontrados:</strong> {{ count($datosCompraventa) }}
            </small>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive-custom">
        <table class="table products-table">
            <thead class="table-header">
                <tr>
                    <th scope="col">Imagen</th>
                    <th scope="col">Título</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datosCompraventa as $producto)
                <tr>
                    <td>
                        <img class="product-image" src="{{asset($producto->imagen)}}" alt="{{$producto->nombre_producto}}"/>
                    </td>
                    <td>
                        <div class="product-title" title="{{$producto->nombre_producto}}">
                            {{$producto->nombre_producto}}
                        </div>
                    </td>
                    <td>
                        <span class="product-price">{{number_format($producto->precio, 2)}} €</span>
                    </td>
                    <td>
                        @if(auth()->user()->tipo_usuario == 1)
                            <div class="owner-info">
                                <div class="owner-name">{{ $producto->user->name ?? 'Usuario eliminado' }}</div>
                                <small class="owner-id">ID: {{$producto->id_user}}</small>
                            </div>
                        @else
                            <span class="badge badge-custom badge-owner">Tu producto</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-custom badge-available">
                            <i class="fas fa-check-circle me-1"></i>Disponible
                        </span>
                    </td>
                    <td>
                        <span class="date-info">
                            {{$producto->created_at ? $producto->created_at->format('d/m/Y') : 'N/A'}}
                        </span>
                    </td>
                    <td>
                        <div class="actions-container">
                            <form action="{{route('productoCompraventa', $producto->id)}}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-view" type="submit" title="Ver producto">
                                    <i class="fas fa-eye me-1"></i>Ver
                                </button>
                            </form>
                            
                            <a href="{{ route('editarCompraventa', $producto->id) }}" class="btn btn-edit" title="Editar producto">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            
                            <form action="{{route('borrarCompraventa', $producto->id)}}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.')">
                                @csrf
                                <button class="btn btn-delete" type="submit" title="Eliminar producto">
                                    <i class="fas fa-trash me-1"></i>Borrar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-box-open fa-4x"></i>
                            <h5>No hay productos disponibles</h5>
                            <p class="mb-3">
                                @if(auth()->user()->tipo_usuario == 1)
                                    No hay productos de compraventa en el sistema.
                                @else
                                    Aún no has publicado ningún producto para la venta.
                                @endif
                            </p>
                            <a href="{{ route('menuNuevoCompraventa') }}" class="btn">
                                <i class="fas fa-plus me-2"></i>Agregar primer producto
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Confirmar borrado con animación
document.querySelectorAll('form[action*="borrarCompraventa"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('¿Estás seguro de que quieres borrar este producto? Esta acción no se puede deshacer.')) {
            e.preventDefault();
        }
    });
});

// Animación suave al cargar
document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('.products-table');
    if (table) {
        table.style.opacity = '0';
        table.style.transform = 'translateY(20px)';
        setTimeout(() => {
            table.style.transition = 'all 0.6s ease';
            table.style.opacity = '1';
            table.style.transform = 'translateY(0)';
        }, 200);
    }
});
</script>

@endsection