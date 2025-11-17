{{-- 
    Vista: Administración de Productos
    Descripción: Página principal del panel de administración donde se listan todos los productos
    Permite: Ver, editar y eliminar productos del inventario
    Acceso: Solo usuarios administradores
--}}

@extends('index')

@section('contenido_principal')
<style>
/* ============================================
   ESTILOS PARA LA PÁGINA DE ADMINISTRACIÓN
   ============================================ */

/* --- Header de Administración --- */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
}

/* --- Contenedor Principal --- */
.admin-container {
    padding: 0 1rem;
}

/* --- Botón para Añadir Producto --- */
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

/* --- Tabla de Productos --- */
.products-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
}

/* --- Cabecera de Tabla --- */
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

/* --- Filas de Tabla --- */
.products-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e9ecef;
}

.products-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01); /* Efecto de zoom al hover */
}

.products-table tbody tr:last-child {
    border-bottom: none;
}

.products-table td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
}

/* --- Imagen del Producto --- */
.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1); /* Zoom en la imagen al hover */
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

/* --- Título del Producto --- */
.product-title {
    font-weight: 600;
    color: #2c3e50;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis; /* Agrega "..." si el texto es muy largo */
    white-space: nowrap;
}

/* --- Precio del Producto --- */
.product-price {
    font-weight: 700;
    color: #667eea;
    font-size: 1.1rem;
}

/* --- Etiqueta de Categoría --- */
.product-type {
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-block;
}

/* --- Contenedor de Acciones (Editar/Borrar) --- */
.actions-container {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

/* --- Botón Editar --- */
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

/* --- Botón Borrar --- */
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

/* --- Contenedor Responsive de Tabla --- */
.table-responsive-custom {
    border-radius: 15px;
    overflow: hidden;
}

/* --- Badge de ID --- */
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

/* ============================================
   MEDIA QUERIES - DISEÑO RESPONSIVE
   ============================================ */

/* --- Tablets y pantallas medianas --- */
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

/* --- Móviles y pantallas pequeñas --- */
@media (max-width: 576px) {
    .btn-add-product {
        width: 100%;
        justify-content: center;
    }
    
    /* Ajuste de ancho de columnas en móvil */
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

{{-- ============================================
     SECCIÓN HTML - CONTENIDO PRINCIPAL
     ============================================ --}}

<div class="admin-container">
    
    {{-- Header Section - Título y descripción --}}
    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-cogs me-3"></i>
                Administración de Productos
            </h1>
            <p class="lead mb-0">Gestiona tu inventario de forma eficiente</p>
        </div>
    </div>

    {{-- Botón para añadir nuevo producto --}}
    <div class="mb-4">
        <a href="{{route('menuNuevo')}}" class="btn-add-product">
            <i class="fas fa-plus me-2"></i>
            Añadir Nuevo Producto
        </a>
    </div>

    {{-- Tabla de productos --}}
    <div class="table-responsive-custom">
        <table class="table products-table">
            {{-- Cabecera de la tabla --}}
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
            
            {{-- Cuerpo de la tabla - Iteración sobre productos --}}
            <tbody>
                @foreach ($datosProductos as $producto)
                    <tr>
                        {{-- ID del producto --}}
                        <td>
                            <span class="id-badge">{{$producto->id}}</span>
                        </td>
                        
                        {{-- Imagen del producto --}}
                        <td>
                            <img class="product-image" 
                                 src="{{asset($producto->imagen)}}" 
                                 alt="{{$producto->titulo}}"/>
                        </td>
                        
                        {{-- Título del producto --}}
                        <td>
                            <div class="product-title" title="{{$producto->titulo}}">
                                {{$producto->titulo}}
                            </div>
                        </td>
                        
                        {{-- Precio formateado --}}
                        <td>
                            <span class="product-price">{{number_format($producto->precio, 2)}} €</span>
                        </td>
                        
                        {{-- Categoría/Tipo de producto --}}
                        <td>
                            <span class="product-type">{{ucfirst($producto->tipo)}}</span>
                        </td>
                        
                        {{-- Botones de acciones (Editar y Borrar) --}}
                        <td>
                            <div class="actions-container">
                                {{-- Formulario para editar --}}
                                <form action="{{route('menuEditar', $producto->id)}}" method="POST" class="d-inline">
                                    {{csrf_field()}}
                                    <button class="btn btn-edit" type="submit" title="Editar producto">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                </form>

                                {{-- Formulario para borrar con confirmación --}}
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

    {{-- Mensaje cuando no hay productos --}}
    @if(count($datosProductos) == 0)
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No hay productos registrados</h4>
            <p class="text-muted">Comienza añadiendo tu primer producto</p>
        </div>
    @endif
</div>

@endsection