{{--
===========================================
VISTA: Editar Producto (Administración)
===========================================
Propósito: Formulario de edición de productos del catálogo
Acceso: Solo administradores (tipo_usuario == 1)
Funcionalidad: Permite actualizar información y imágenes de productos existentes
Ruta: /administrar/editar/{id}
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === ENCABEZADO ADMINISTRATIVO === */
/* Estilos modernos para la página de edición de productos */
.admin-header {
    /* Gradiente púrpura moderno para el header */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    /* Esquinas redondeadas para diseño moderno */
    border-radius: 15px;
}

/* === CONTENEDOR PRINCIPAL === */
.edit-container {
    /* Ancho máximo para formularios legibles */
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* === TARJETA DE EDICIÓN === */
.edit-card {
    background: white;
    /* Bordes redondeados */
    border-radius: 15px;
    /* Sombra pronunciada para profundidad */
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

/* === SECCIONES DEL FORMULARIO === */
.form-section {
    padding: 2rem;
}

.form-group {
    /* Espaciado entre campos */
    margin-bottom: 1.5rem;
}

/* === ETIQUETAS DE CAMPOS === */
.form-label {
    /* Gradiente gris para etiquetas */
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    padding: 8px 15px;
    /* Solo redondeado arriba */
    border-radius: 20px 20px 0 0;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0;
    display: block;
}

/* === INPUTS MODERNOS === */
.form-control-modern {
    border: 2px solid #e9ecef;
    /* Redondeado excepto esquina superior izquierda */
    border-radius: 0 10px 10px 10px;
    padding: 12px 15px;
    font-size: 1rem;
    /* Transición suave para efectos */
    transition: all 0.3s ease;
    /* Sin borde superior para conectar con label */
    border-top: none;
    width: 100%;
}

.form-control-modern:focus {
    /* Borde morado al enfocar */
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}

.form-control-modern:invalid {
    /* Borde rojo para campos inválidos */
    border-color: #dc3545;
}

.form-control-modern:valid {
    /* Borde verde para campos válidos */
    border-color: #28a745;
}

/* === SECCIÓN DE IMÁGENES === */
/* Sección de imágenes */
.images-section {
    /* Fondo gris claro para distinguir sección */
    background: #f8f9fa;
    padding: 2rem;
    border-bottom: 1px solid #e9ecef;
}

/* === IMAGEN PRINCIPAL === */
.main-image-container {
    position: relative;
    text-align: center;
    margin-bottom: 2rem;
}

.main-image-preview {
    /* Tamaño cuadrado para imagen principal */
    width: 250px;
    height: 250px;
    /* Recorte proporcional de la imagen */
    object-fit: cover;
    border-radius: 15px;
    /* Sombra para destacar */
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    /* Borde blanco decorativo */
    border: 4px solid white;
}

.main-image-preview:hover {
    /* Efecto de zoom al pasar cursor */
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

/* === OVERLAY DE CARGA === */
.image-upload-overlay {
    /* Posicionamiento absoluto sobre la imagen */
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 250px;
    height: 250px;
    /* Overlay morado semi-transparente */
    background: rgba(102, 126, 234, 0.8);
    border-radius: 15px;
    /* Centrado de contenido */
    display: flex;
    align-items: center;
    justify-content: center;
    /* Oculto por defecto */
    opacity: 0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.main-image-container:hover .image-upload-overlay {
    /* Mostrar overlay al hover */
    opacity: 1;
}

.image-upload-overlay i {
    /* Icono grande de cámara */
    font-size: 2rem;
    color: white;
}

.image-upload-overlay span {
    color: white;
    font-weight: 600;
    margin-top: 0.5rem;
}

/* === IMÁGENES ADICIONALES === */
.additional-images {
    /* Grid responsive para múltiples imágenes */
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
    /* Altura fija para uniformidad */
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    margin-bottom: 0.5rem;
}

/* === INPUT OCULTO === */
.image-upload-input {
    /* Input file oculto (se activa con JS) */
    display: none;
}

/* === BOTONES DE CARGA === */
.image-upload-btn {
    width: 100%;
    padding: 8px 12px;
    /* Gradiente azul */
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
    /* Gradiente más oscuro al hover */
    background: linear-gradient(45deg, #0056b3, #004085);
    /* Efecto de elevación */
    transform: translateY(-1px);
}

/* === BOTONES DE ACCIÓN === */
/* Botones de acción */
.action-buttons {
    background: #f8f9fa;
    padding: 1.5rem 2rem;
    /* Distribución espaciada */
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e9ecef;
}

/* === BOTÓN CANCELAR === */
.btn-cancel {
    /* Gradiente gris */
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
    /* Gris más oscuro al hover */
    background: linear-gradient(45deg, #5a6268, #495057);
    /* Efecto de elevación */
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.4);
    color: white;
    text-decoration: none;
}

/* === BOTÓN GUARDAR === */
.btn-save {
    /* Gradiente verde */
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
    /* Verde más oscuro al hover */
    background: linear-gradient(45deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    color: white;
}

/* === DISEÑO RESPONSIVE === */
/* Responsive adjustments */
/* Tablets y pantallas medianas */
@media (max-width: 768px) {
    .admin-header {
        /* Padding reducido en móvil */
        padding: 1.5rem 0;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .images-section {
        padding: 1.5rem;
    }
    
    .main-image-preview {
        /* Imagen principal más pequeña */
        width: 200px;
        height: 200px;
    }
    
    .image-upload-overlay {
        width: 200px;
        height: 200px;
    }
    
    .additional-images {
        /* 2 columnas en tablets */
        grid-template-columns: repeat(2, 1fr);
    }
    }
    
    .action-buttons {
        /* Botones en columna en móvil */
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-cancel, .btn-save {
        /* Botones a ancho completo */
        width: 100%;
        text-align: center;
    }
}

/* Móviles pequeños */
@media (max-width: 576px) {
    .main-image-preview {
        /* Imagen aún más pequeña en móviles */
        width: 150px;
        height: 150px;
    }
    
    .image-upload-overlay {
        width: 150px;
        height: 150px;
    }
    
    .additional-images {
        /* 1 columna en móviles pequeños */
        grid-template-columns: 1fr;
    }
}
</style>

<div class="edit-container">
    {{-- === ENCABEZADO DE LA PÁGINA === --}}
    <!-- Header Section -->
    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-edit me-3"></i>
                Editar Producto
            </h1>
            {{-- Mostrar el título del producto actual --}}
            <p class="lead mb-0">{{$producto->titulo}}</p>
        </div>
    </div>

    {{-- === FORMULARIO PRINCIPAL === --}}
    {{-- Envía a la ruta confirmarCambios con método POST --}}
    {{-- enctype="multipart/form-data" permite subir archivos --}}
    <form id="confirmar" action="{{route('confirmarCambios', $producto->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="edit-card">
            {{-- === SECCIÓN DE IMÁGENES === --}}
            <!-- Images Section -->
            <div class="images-section">
                <h5 class="fw-bold mb-3 text-center">
                    <i class="fas fa-images me-2" style="color: #667eea;"></i>
                    Gestión de Imágenes
                </h5>
                
                {{-- Imagen Principal --}}
                <!-- Main Image -->
                <div class="main-image-container">
                    {{-- Muestra la imagen actual del producto --}}
                    <img class="main-image-preview" src="{{asset($producto->imagen)}}" alt="Imagen principal" id="mainImagePreview"/>
                    {{-- Overlay que aparece al hacer hover --}}
                    <div class="image-upload-overlay" onclick="document.getElementById('file-input').click()">
                        <div class="text-center">
                            <i class="fas fa-camera"></i>
                            <div><span>Cambiar imagen</span></div>
                        </div>
                    </div>
                    {{-- Input file oculto que se activa al clic en el overlay --}}
                    {{-- onchange llama a función JS para preview --}}
                    <input onchange="mostrar_nueva_img(this)" id="file-input" type="file" name="nueva_imagen" class="image-upload-input" accept="image/*"/>
                </div>

                {{-- Imágenes Adicionales (2, 3 y 4) --}}
                <!-- Additional Images Upload -->
                <div class="additional-images">
                    {{-- Imagen 2 --}}
                    <div class="additional-image-item">
                        {{-- Muestra img2 o placeholder si no existe --}}
                        <img src="{{$producto->img2 ? asset($producto->img2) : 'https://via.placeholder.com/150x120?text=Imagen+2'}}" 
                             alt="Imagen 2" class="additional-image-preview" id="img2Preview">
                        <button type="button" class="image-upload-btn" onclick="document.getElementById('img2-input').click()">
                            <i class="fas fa-upload me-1"></i>Imagen 2
                        </button>
                        <input type="file" id="img2-input" name="img2" class="image-upload-input" 
                               accept="image/*" onchange="previewImage(this, 'img2Preview')">
                    </div>
                    
                    {{-- Imagen 3 --}}
                    <div class="additional-image-item">
                        <img src="{{$producto->img3 ? asset($producto->img3) : 'https://via.placeholder.com/150x120?text=Imagen+3'}}" 
                             alt="Imagen 3" class="additional-image-preview" id="img3Preview">
                        <button type="button" class="image-upload-btn" onclick="document.getElementById('img3-input').click()">
                            <i class="fas fa-upload me-1"></i>Imagen 3
                        </button>
                        <input type="file" id="img3-input" name="img3" class="image-upload-input" 
                               accept="image/*" onchange="previewImage(this, 'img3Preview')">
                    </div>
                    
                    {{-- Imagen 4 --}}
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

            {{-- === SECCIÓN DEL FORMULARIO DE DATOS === --}}
            <!-- Form Section -->
            <div class="form-section">
                <div class="row">
                    {{-- === COLUMNA IZQUIERDA === --}}
                    <div class="col-md-6">
                        {{-- Campo: Título --}}
                        <!-- Título -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag me-1"></i>Título del Producto
                            </label>
                            {{-- value carga el valor actual del producto --}}
                            <input type="text" class="form-control-modern" name="titulo" value="{{$producto->titulo}}" required>
                        </div>

                        {{-- Campo: Descripción --}}
                        <!-- Descripción -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left me-1"></i>Descripción
                            </label>
                            {{-- Textarea con 3 filas --}}
                            <textarea class="form-control-modern" name="descripcion" rows="3" required>{{$producto->descripcion}}</textarea>
                        </div>

                        {{-- Campo: Precio --}}
                        <!-- Precio -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-euro-sign me-1"></i>Precio
                            </label>
                            <div class="input-group">
                                {{-- step="0.01" permite decimales --}}
                                <input type="number" step="0.01" class="form-control-modern" name="precio" value="{{$producto->precio}}" required>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>

                        {{-- Campo: Marca --}}
                        <!-- Marca -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-copyright me-1"></i>Marca
                            </label>
                            <input type="text" class="form-control-modern" name="marca" value="{{$producto->marca}}" required>
                        </div>
                    </div>

                    {{-- === COLUMNA DERECHA === --}}
                    <div class="col-md-6">
                        {{-- Campo: Tipo de Producto --}}
                        <!-- Tipo -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-list me-1"></i>Tipo de Producto
                            </label>
                            {{-- Select con 3 opciones: ropa, calzado, complementos --}}
                            <select name="tipo" class="form-control-modern" id="tipo" required>
                                {{-- Operador ternario para marcar la opción actual --}}
                                <option value="ropa" {{$producto->tipo == 'ropa' ? 'selected' : ''}}>Ropa</option>
                                <option value="calzado" {{$producto->tipo == 'calzado' ? 'selected' : ''}}>Calzado</option>
                                <option value="complementos" {{$producto->tipo == 'complementos' ? 'selected' : ''}}>Complementos</option>
                            </select>
                        </div>

                        {{-- Campo: Categoría (depende del tipo) --}}
                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tags me-1"></i>Categoría
                            </label>
                            {{-- Las opciones cambian según el tipo de producto --}}
                            <select name="categoria_prenda" class="form-control-modern" id="categoria_prenda" required>
                                {{-- Opciones para ROPA --}}
                                @if($producto->tipo == 'ropa')
                                    <option value="sudadera con capucha" {{$producto->categoria_prenda == 'sudadera con capucha' ? 'selected' : ''}}>Sudadera con capucha</option>
                                    <option value="sudadera/jersey" {{$producto->categoria_prenda == 'sudadera/jersey' ? 'selected' : ''}}>Sudadera/Jersey</option>
                                    <option value="chaqueta" {{$producto->categoria_prenda == 'chaqueta' ? 'selected' : ''}}>Chaqueta</option>
                                    <option value="camiseta" {{$producto->categoria_prenda == 'camiseta' ? 'selected' : ''}}>Camiseta</option>
                                    <option value="pantalones vaqueros" {{$producto->categoria_prenda == 'pantalones vaqueros' ? 'selected' : ''}}>Pantalones vaqueros</option>
                                    <option value="otros pantalones" {{$producto->categoria_prenda == 'otros pantalones' ? 'selected' : ''}}>Otros pantalones</option>
                                    <option value="falda" {{$producto->categoria_prenda == 'falda' ? 'selected' : ''}}>Falda</option>
                                    <option value="chandal" {{$producto->categoria_prenda == 'chandal' ? 'selected' : ''}}>Chandal</option>
                                {{-- Opciones para CALZADO --}}
                                @elseif($producto->tipo == 'calzado')
                                    <option value="zapato de vestir" {{$producto->categoria_prenda == 'zapato de vestir' ? 'selected' : ''}}>Zapato de vestir</option>
                                    <option value="zapato skate" {{$producto->categoria_prenda == 'zapato skate' ? 'selected' : ''}}>Zapato skate</option>
                                    <option value="playero de deporte" {{$producto->categoria_prenda == 'playero de deporte' ? 'selected' : ''}}>Playero de deporte</option>
                                    <option value="chanclas" {{$producto->categoria_prenda == 'chanclas' ? 'selected' : ''}}>Chanclas</option>
                                    <option value="zapatillas" {{$producto->categoria_prenda == 'zapatillas' ? 'selected' : ''}}>Zapatillas</option>
                                {{-- Opciones para COMPLEMENTOS --}}
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

                        {{-- Campo: Género --}}
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

            {{-- === BOTONES DE ACCIÓN === --}}
            <!-- Action Buttons -->
            <div class="action-buttons">
                {{-- Botón Cancelar: vuelve a la página de administración --}}
                <a href="{{route('administrar')}}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                {{-- Botón Guardar: envía el formulario --}}
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

{{-- === JAVASCRIPT === --}}
<script>
// === FUNCIÓN: Preview para imagen principal ===
// Muestra la imagen seleccionada antes de subirla
function mostrar_nueva_img(input) {
    // Verifica que se haya seleccionado un archivo
    if (input.files && input.files[0]) {
        // FileReader lee el archivo como URL
        var reader = new FileReader();
        reader.onload = function(e) {
            // Actualiza el src de la imagen de preview
            document.getElementById('mainImagePreview').src = e.target.result;
        }
        // Lee el archivo como Data URL
        reader.readAsDataURL(input.files[0]);
    }
}

// === FUNCIÓN: Preview para imágenes adicionales ===
// Parámetros: input (elemento file), previewId (id de la imagen a actualizar)
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Actualiza la imagen específica por su ID
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// === VALIDACIÓN DEL FORMULARIO ===
// Verifica que todos los campos requeridos estén completos
document.getElementById('confirmar').addEventListener('submit', function(e) {
    // Array con los nombres de campos obligatorios
    const requiredFields = ['titulo', 'descripcion', 'precio', 'marca', 'tipo', 'categoria_prenda', 'genero'];
    let isValid = true;
    
    // Itera sobre cada campo requerido
    requiredFields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        // Verifica si el campo está vacío
        if (!input.value.trim()) {
            // Marca el campo como inválido (borde rojo)
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            // Marca el campo como válido (borde verde)
            input.style.borderColor = '#28a745';
        }
    });
    
    // Si hay campos inválidos, previene el envío
    if (!isValid) {
        e.preventDefault();
        alert('Por favor, completa todos los campos obligatorios.');
    }
});

// === ANIMACIÓN DE CARGA ===
// Efecto fade-in al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const card = document.querySelector('.edit-card');
    // Estado inicial: invisible y desplazado
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    // Después de 200ms, anima la entrada
    setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 200);
});
</script>

@endsection