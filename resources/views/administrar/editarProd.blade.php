@extends('index')

@section('contenido_principal')

<style>
/* Estilos modernos para la página de edición de productos */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
}

.edit-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.edit-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.form-section {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    padding: 8px 15px;
    border-radius: 20px 20px 0 0;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0;
    display: block;
}

.form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 0 10px 10px 10px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
    border-top: none;
    width: 100%;
}

.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}

.form-control-modern:invalid {
    border-color: #dc3545;
}

.form-control-modern:valid {
    border-color: #28a745;
}

/* Sección de imágenes */
.images-section {
    background: #f8f9fa;
    padding: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.main-image-container {
    position: relative;
    text-align: center;
    margin-bottom: 2rem;
}

.main-image-preview {
    width: 250px;
    height: 250px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 4px solid white;
}

.main-image-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.image-upload-overlay {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 250px;
    height: 250px;
    background: rgba(102, 126, 234, 0.8);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.main-image-container:hover .image-upload-overlay {
    opacity: 1;
}

.image-upload-overlay i {
    font-size: 2rem;
    color: white;
}

.image-upload-overlay span {
    color: white;
    font-weight: 600;
    margin-top: 0.5rem;
}

.additional-images {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 2rem;
}

.additional-image-item {
    text-align: center;
}

.additional-image-preview {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    margin-bottom: 0.5rem;
}

.image-upload-input {
    display: none;
}

.image-upload-btn {
    width: 100%;
    padding: 8px 12px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 20px;
    color: white;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.image-upload-btn:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-1px);
}

/* Botones de acción */
.action-buttons {
    background: #f8f9fa;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e9ecef;
}

.btn-cancel {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}

.btn-cancel:hover {
    background: linear-gradient(45deg, #5a6268, #495057);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.4);
    color: white;
    text-decoration: none;
}

.btn-save {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.btn-save:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .admin-header {
        padding: 1.5rem 0;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .images-section {
        padding: 1.5rem;
    }
    
    .main-image-preview {
        width: 200px;
        height: 200px;
    }
    
    .image-upload-overlay {
        width: 200px;
        height: 200px;
    }
    
    .additional-images {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-cancel, .btn-save {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .main-image-preview {
        width: 150px;
        height: 150px;
    }
    
    .image-upload-overlay {
        width: 150px;
        height: 150px;
    }
    
    .additional-images {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="edit-container">
    <!-- Header Section -->
    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-edit me-3"></i>
                Editar Producto
            </h1>
            <p class="lead mb-0">{{$producto->titulo}}</p>
        </div>
    </div>

    <form id="confirmar" action="{{route('confirmarCambios', $producto->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="edit-card">
            <!-- Images Section -->
            <div class="images-section">
                <h5 class="fw-bold mb-3 text-center">
                    <i class="fas fa-images me-2" style="color: #667eea;"></i>
                    Gestión de Imágenes
                </h5>
                
                <!-- Main Image -->
                <div class="main-image-container">
                    <img class="main-image-preview" src="{{asset($producto->imagen)}}" alt="Imagen principal" id="mainImagePreview"/>
                    <div class="image-upload-overlay" onclick="document.getElementById('file-input').click()">
                        <div class="text-center">
                            <i class="fas fa-camera"></i>
                            <div><span>Cambiar imagen</span></div>
                        </div>
                    </div>
                    <input onchange="mostrar_nueva_img(this)" id="file-input" type="file" name="nueva_imagen" class="image-upload-input" accept="image/*"/>
                </div>

                <!-- Additional Images Upload -->
                <div class="additional-images">
                    <div class="additional-image-item">
                        <img src="{{$producto->img2 ? asset($producto->img2) : 'https://via.placeholder.com/150x120?text=Imagen+2'}}" 
                             alt="Imagen 2" class="additional-image-preview" id="img2Preview">
                        <button type="button" class="image-upload-btn" onclick="document.getElementById('img2-input').click()">
                            <i class="fas fa-upload me-1"></i>Imagen 2
                        </button>
                        <input type="file" id="img2-input" name="img2" class="image-upload-input" 
                               accept="image/*" onchange="previewImage(this, 'img2Preview')">
                    </div>
                    
                    <div class="additional-image-item">
                        <img src="{{$producto->img3 ? asset($producto->img3) : 'https://via.placeholder.com/150x120?text=Imagen+3'}}" 
                             alt="Imagen 3" class="additional-image-preview" id="img3Preview">
                        <button type="button" class="image-upload-btn" onclick="document.getElementById('img3-input').click()">
                            <i class="fas fa-upload me-1"></i>Imagen 3
                        </button>
                        <input type="file" id="img3-input" name="img3" class="image-upload-input" 
                               accept="image/*" onchange="previewImage(this, 'img3Preview')">
                    </div>
                    
                    <div class="additional-image-item">
                        <img src="{{$producto->img4 ? asset($producto->img4) : 'https://via.placeholder.com/150x120?text=Imagen+4'}}" 
                             alt="Imagen 4" class="additional-image-preview" id="img4Preview">
                        <button type="button" class="image-upload-btn" onclick="document.getElementById('img4-input').click()">
                            <i class="fas fa-upload me-1"></i>Imagen 4
                        </button>
                        <input type="file" id="img4-input" name="img4" class="image-upload-input" 
                               accept="image/*" onchange="previewImage(this, 'img4Preview')">
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Título -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag me-1"></i>Título del Producto
                            </label>
                            <input type="text" class="form-control-modern" name="titulo" value="{{$producto->titulo}}" required>
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left me-1"></i>Descripción
                            </label>
                            <textarea class="form-control-modern" name="descripcion" rows="3" required>{{$producto->descripcion}}</textarea>
                        </div>

                        <!-- Precio -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-euro-sign me-1"></i>Precio
                            </label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control-modern" name="precio" value="{{$producto->precio}}" required>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>

                        <!-- Marca -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-copyright me-1"></i>Marca
                            </label>
                            <input type="text" class="form-control-modern" name="marca" value="{{$producto->marca}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Tipo -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-list me-1"></i>Tipo de Producto
                            </label>
                            <select name="tipo" class="form-control-modern" id="tipo" required>
                                <option value="ropa" {{$producto->tipo == 'ropa' ? 'selected' : ''}}>Ropa</option>
                                <option value="calzado" {{$producto->tipo == 'calzado' ? 'selected' : ''}}>Calzado</option>
                                <option value="complementos" {{$producto->tipo == 'complementos' ? 'selected' : ''}}>Complementos</option>
                            </select>
                        </div>

                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tags me-1"></i>Categoría
                            </label>
                            <select name="categoria_prenda" class="form-control-modern" id="categoria_prenda" required>
                                @if($producto->tipo == 'ropa')
                                    <option value="sudadera con capucha" {{$producto->categoria_prenda == 'sudadera con capucha' ? 'selected' : ''}}>Sudadera con capucha</option>
                                    <option value="sudadera/jersey" {{$producto->categoria_prenda == 'sudadera/jersey' ? 'selected' : ''}}>Sudadera/Jersey</option>
                                    <option value="chaqueta" {{$producto->categoria_prenda == 'chaqueta' ? 'selected' : ''}}>Chaqueta</option>
                                    <option value="camiseta" {{$producto->categoria_prenda == 'camiseta' ? 'selected' : ''}}>Camiseta</option>
                                    <option value="pantalones vaqueros" {{$producto->categoria_prenda == 'pantalones vaqueros' ? 'selected' : ''}}>Pantalones vaqueros</option>
                                    <option value="otros pantalones" {{$producto->categoria_prenda == 'otros pantalones' ? 'selected' : ''}}>Otros pantalones</option>
                                    <option value="falda" {{$producto->categoria_prenda == 'falda' ? 'selected' : ''}}>Falda</option>
                                    <option value="chandal" {{$producto->categoria_prenda == 'chandal' ? 'selected' : ''}}>Chandal</option>
                                @elseif($producto->tipo == 'calzado')
                                    <option value="zapato de vestir" {{$producto->categoria_prenda == 'zapato de vestir' ? 'selected' : ''}}>Zapato de vestir</option>
                                    <option value="zapato skate" {{$producto->categoria_prenda == 'zapato skate' ? 'selected' : ''}}>Zapato skate</option>
                                    <option value="playero de deporte" {{$producto->categoria_prenda == 'playero de deporte' ? 'selected' : ''}}>Playero de deporte</option>
                                    <option value="chanclas" {{$producto->categoria_prenda == 'chanclas' ? 'selected' : ''}}>Chanclas</option>
                                    <option value="zapatillas" {{$producto->categoria_prenda == 'zapatillas' ? 'selected' : ''}}>Zapatillas</option>
                                @else
                                    <option value="anillo" {{$producto->categoria_prenda == 'anillo' ? 'selected' : ''}}>Anillo</option>
                                    <option value="collar" {{$producto->categoria_prenda == 'collar' ? 'selected' : ''}}>Collar</option>
                                    <option value="pulsera" {{$producto->categoria_prenda == 'pulsera' ? 'selected' : ''}}>Pulsera</option>
                                    <option value="pendientes" {{$producto->categoria_prenda == 'pendientes' ? 'selected' : ''}}>Pendientes</option>
                                    <option value="gorra" {{$producto->categoria_prenda == 'gorra' ? 'selected' : ''}}>Gorra</option>
                                    <option value="gafas de sol" {{$producto->categoria_prenda == 'gafas de sol' ? 'selected' : ''}}>Gafas de sol</option>
                                    <option value="gafas" {{$producto->categoria_prenda == 'gafas' ? 'selected' : ''}}>Gafas</option>
                                    <option value="calcetines" {{$producto->categoria_prenda == 'calcetines' ? 'selected' : ''}}>Calcetines</option>
                                @endif
                            </select>
                        </div>

                        <!-- Género -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars me-1"></i>Género
                            </label>
                            <select name="genero" class="form-control-modern" id="genero" required>
                                <option value="masculino" {{$producto->genero == 'masculino' ? 'selected' : ''}}>Masculino</option>
                                <option value="femenino" {{$producto->genero == 'femenino' ? 'selected' : ''}}>Femenino</option>
                                <option value="unisex" {{$producto->genero == 'unisex' ? 'selected' : ''}}>Unisex</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{route('administrar')}}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Preview para imagen principal
function mostrar_nueva_img(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainImagePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview para imágenes adicionales
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Validación del formulario
document.getElementById('confirmar').addEventListener('submit', function(e) {
    const requiredFields = ['titulo', 'descripcion', 'precio', 'marca', 'tipo', 'categoria_prenda', 'genero'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (!input.value.trim()) {
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            input.style.borderColor = '#28a745';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Por favor, completa todos los campos obligatorios.');
    }
});

// Animación al cargar
document.addEventListener('DOMContentLoaded', function() {
    const card = document.querySelector('.edit-card');
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 200);
});
</script>

@endsection