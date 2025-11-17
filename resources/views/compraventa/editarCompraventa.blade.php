@extends('index')

@section('contenido_principal')
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.preview-image {
    max-width: 200px;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>

<div class="container mt-4">
    <div class="form-container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-edit me-2"></i>Editar Producto de Compraventa
                </h2>
                <p class="text-muted">Modifica los detalles del producto</p>
            </div>
        </div>

        <form action="{{ route('actualizarCompraventa', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label fw-semibold">
                            <i class="fas fa-tag me-1"></i>Nombre del Producto
                        </label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" 
                               value="{{ $producto->nombre_producto }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label fw-semibold">
                            <i class="fas fa-euro-sign me-1"></i>Precio
                        </label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" 
                                   value="{{ $producto->precio }}" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contacto" class="form-label fw-semibold">
                            <i class="fas fa-phone me-1"></i>Contacto
                        </label>
                        <input type="text" class="form-control" id="contacto" name="contacto" 
                               value="{{ $producto->contacto }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="descripcion_producto" class="form-label fw-semibold">
                            <i class="fas fa-align-left me-1"></i>Descripción
                        </label>
                        <textarea class="form-control" id="descripcion_producto" name="descripcion_producto" 
                                  rows="5" required>{{ $producto->descripcion_producto }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="nueva_imagen" class="form-label fw-semibold">
                            <i class="fas fa-image me-1"></i>Nueva Imagen (opcional)
                        </label>
                        <input type="file" class="form-control" id="nueva_imagen" name="nueva_imagen" accept="image/*">
                        <small class="form-text text-muted">Deja vacío si no quieres cambiar la imagen actual</small>
                    </div>

                    @if($producto->imagen)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Imagen Actual:</label>
                        <br>
                        <img src="{{ asset($producto->imagen) }}" alt="Imagen actual" class="preview-image">
                    </div>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('compraventa_administrar') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                        
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-1"></i>Restaurar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Actualizar Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Preview de imagen antes de subir
document.getElementById('nueva_imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crear o actualizar preview
            let preview = document.getElementById('preview-nueva-imagen');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'preview-nueva-imagen';
                preview.className = 'preview-image mt-2';
                e.target.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection
