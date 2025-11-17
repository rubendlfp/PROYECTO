@extends('index')

@section('contenido_principal')
<style>
/* Estilos para la página de administración de productos */
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
    margin-bottom: 2rem;
}

.btn-add-product:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
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

.product-type {
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-block;
}

.actions-container {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.btn-edit {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
}

.btn-edit:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    color: white;
}

.btn-delete {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
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

.table-responsive-custom {
    border-radius: 15px;
    overflow: hidden;
}

/* ID Badge */
.id-badge {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 4px 8px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.9rem;
    min-width: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
    
    .btn-edit, .btn-delete {
        padding: 6px 12px;
        font-size: 0.8rem;
        width: 100%;
    }
    
    .product-title {
        max-width: 120px;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .btn-add-product {
        width: 100%;
        justify-content: center;
    }
    
    .table-header th:nth-child(2),
    .products-table td:nth-child(2) {
        width: 80px;
    }
    
    .table-header th:nth-child(6),
    .products-table td:nth-child(6) {
        width: 120px;
    }
}
</style>

<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-cogs me-3"></i>
                Administración de Productos
            </h1>
            <p class="lead mb-0">Gestiona tu inventario de forma eficiente</p>
        </div>
    </div>

    <!-- Add Product Button -->
    <div class="mb-4">
        <a href="{{route('menuNuevo')}}" class="btn-add-product">
            <i class="fas fa-plus me-2"></i>
            Añadir Nuevo Producto
        </a>
    </div>

    <!-- Products Table -->
    <div class="table-responsive-custom">
        <table class="table products-table">
            <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Título</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosProductos as $producto)
                    <tr>
                        <td>
                            <span class="id-badge">{{$producto->id}}</span>
                        </td>
                        <td>
                            <img class="product-image" src="{{asset($producto->imagen)}}" alt="{{$producto->titulo}}"/>
                        </td>
                        <td>
                            <div class="product-title" title="{{$producto->titulo}}">
                                {{$producto->titulo}}
                            </div>
                        </td>
                        <td>
                            <span class="product-price">{{number_format($producto->precio, 2)}} €</span>
                        </td>
                        <td>
                            <span class="product-type">{{ucfirst($producto->tipo)}}</span>
                        </td>
                        <td>
                            <div class="actions-container">
                                <form action="{{route('menuEditar', $producto->id)}}" method="POST" class="d-inline">
                                    {{csrf_field()}}
                                    <button class="btn btn-edit" type="submit" title="Editar producto">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                </form>

                                <form action="{{route('borrar', $producto->id)}}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                    {{csrf_field()}}
                                    <button class="btn btn-delete" type="submit" title="Eliminar producto">
                                        <i class="fas fa-trash me-1"></i>Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($datosProductos) == 0)
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No hay productos registrados</h4>
            <p class="text-muted">Comienza añadiendo tu primer producto</p>
        </div>
    @endif
</div>

@endsection