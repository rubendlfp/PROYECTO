{{--
===========================================
VISTA: Nuevo Producto (Administración)
===========================================
Propósito: Formulario para crear nuevos productos en el catálogo
Acceso: Solo administradores (tipo_usuario == 1)
Funcionalidad: Permite añadir productos con imágenes, datos básicos y categorización
Ruta: /administrar/nuevo
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
    /* === CONTENEDOR DE EDICIÓN === */
    /* Centrado del formulario */
    .div_editar {
        /* Ancho del 25% centrado */
        width: 25%;
        /* Margen izquierdo para centrar: (100% - 25%) / 2 = 37.5% */
        margin-left: 37%;
    }

    /* === INPUT DE IMAGEN === */
    .input_imagen > input {
        /* Oculta el input file nativo */
        display: none;
    }

    /* === IMAGEN DE EDICIÓN === */
    .editar_imagen {
        position: relative;
        /* Ancho del 80% del contenedor */
        width: 80%;
    }

    /* === BOTONES === */
    #boton_cancelar {
        /* Centrado del botón cancelar */
        margin-left: 40%;
    }

    #boton_guardar {
        position: absolute;
        /* Espaciado desde el botón cancelar */
        margin-left: 2%;
    }
</style>

<div class="">
    {{-- === FORMULARIO PRINCIPAL === --}}
    {{-- Envía a la ruta nuevoProd con método POST --}}
    {{-- enctype="multipart/form-data" permite subir archivos --}}
    <form id="confirmar" action="{{route('nuevoProd')}}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- === INPUT IMAGEN PRINCIPAL === --}}
        <!-- {{-- Input imagen --}} -->
        <div class="div_editar_img text-center">
            <div class="input_imagen">
                {{-- Label actúa como botón para seleccionar archivo --}}
                <label for="file-input">
                    {{-- Imagen por defecto que se mostrará inicialmente --}}
                    <img class="editar_imagen img-responsive" src="{{asset('img/productos/default.jpg')}}"/>
                </label>
                {{-- Input file oculto que se activa al hacer clic en la imagen --}}
                {{-- onchange llama a función JS para preview en tiempo real --}}
                <input onchange="mostrar_nueva_img(this)" id="file-input" type="file" name="nueva_imagen"/>
            </div><br>
        </div>
        
        {{-- === INPUT TÍTULO === --}}
        <!-- {{-- Input Titulo --}} -->
        <div class="div_editar">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Titulo</span>
                </div>
                {{-- Campo requerido para el nombre del producto --}}
                <input required type="text" class="form-control" name="titulo">
            </div>
        </div><br>
    </div>

    {{-- === INPUT DESCRIPCIÓN === --}}
    <!-- {{-- Input Descripcion --}} -->
    <div class="div_editar">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">Descripcion</span>
            </div>
            {{-- Descripción del producto (campo obligatorio) --}}
            <input required type="text" class="form-control" name="descripcion">
        </div>
    </div><br>
</div>

{{-- === INPUT PRECIO === --}}
<!-- {{-- Input Precio --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Precio</span>
        </div>
        {{-- Campo de precio (debería ser type="number" para validación) --}}
        <input required type="text" class="form-control" name="precio">
        <div class="input-group-append">
            {{-- Símbolo de euro al final --}}
            <span class="input-group-text">€</span>
        </div>
    </div><br>
</div>

{{-- === INPUT VALORACIÓN === --}}
<!-- {{-- Input Valoracion --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Valoración</span>
        </div>
        {{-- Select de valoración de 0 a 5 estrellas --}}
        <select name="valoracion" class="form-control" id="valoracion">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div><br>
</div>

{{-- === INPUT TIPO DE PRODUCTO === --}}
<!-- {{-- Input Tipo --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Tipo</span>
        </div>
        {{-- Select que determina las categorías disponibles --}}
        {{-- Cambia dinámicamente las opciones de categoría con JavaScript --}}
        <select required name="tipo" class="form-control" id="tipo">
            <option value="ropa">Ropa</option>
            <option value="calzado">Calzado</option>
            <option value="complementos">Complementos</option>
        </select>
    </div><br>
</div>

{{-- === INPUT MARCA === --}}
<!-- {{-- Input Marca --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Marca</span>
        </div>
        {{-- Marca del producto --}}
        <input required type="text" class="form-control" name="marca">
    </div>
</div><br>
</div>

{{-- === INPUT GÉNERO === --}}
<!-- {{-- Input Genero --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Genero</span>
        </div>
        {{-- Select para género del producto --}}
        <select required name="genero" class="form-control" id="genero">
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="unisex">Unisex</option>
        </select>
    </div><br>
</div>

{{-- === INPUT CATEGORÍA === --}}
<!-- {{-- Input Categoria Prenda --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Categoria</span>
        </div>
        {{-- Select dinámico que cambia según el tipo seleccionado --}}
        {{-- Las opciones se llenan con JavaScript al cambiar el tipo --}}
        <select required name="categoria_prenda" class="form-control" id="categoria_prenda">
            <option value="">Selecciona una categoría</option>
            <!-- Opciones se llenarán dinámicamente con JavaScript -->
        </select>
    </div><br>
</div>

{{-- === IMÁGENES ADICIONALES === --}}
<!-- {{-- Input img2 --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Imagen 2</span>
        </div>
        {{-- Imagen adicional opcional --}}
        <input type="file" class="form-control" name="img2">
    </div>
</div><br>
</div>

<!-- {{-- Input img3 --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Imagen 3</span>
        </div>
        {{-- Imagen adicional opcional --}}
        <input type="file" class="form-control" name="img3">
    </div>
</div><br>
</div>

<!-- {{-- Input img4 --}} -->
<div class="div_editar">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Imagen 4</span>
        </div>
        {{-- Imagen adicional opcional --}}
        <input type="file" class="form-control" name="img4">
    </div>
</div><br>
</div>
            
<br>
{{-- === BOTONES DE ACCIÓN === --}}
<div>
    {{-- Botón Cancelar: redirige a la página de administración --}}
    <a href="{{route('administrar')}}"><input type="button" id="boton_cancelar" class="btn btn-danger" value="Cancelar"></a>
    {{-- Botón Guardar: envía el formulario --}}
    <button id="boton_guardar" class="btn btn-info">Guardar</button>
</div>
</form>
</div>
{{-- Espaciador inferior --}}
<div style="height: 40px;"></div>

{{-- === JAVASCRIPT === --}}
<script>
    // === FUNCIÓN: Preview de imagen principal ===
    // Muestra la imagen seleccionada antes de subirla
    function mostrar_nueva_img(e) {
        // Verifica que se haya seleccionado un archivo
        if (e.files[0]) {
            // FileReader lee el archivo como URL
            var reader = new FileReader();
            reader.onload = function(e) {
                // Actualiza el src de la imagen de preview
                document.querySelector('.editar_imagen').setAttribute('src', e.target.result);
            }
            // Lee el archivo como Data URL
            reader.readAsDataURL(e.files[0]);
        }
    }

    // === CATEGORÍAS DINÁMICAS ===
    // Script para cambiar las opciones de categoría según el tipo seleccionado
    document.getElementById('tipo').addEventListener('change', function() {
        // Obtiene el valor del tipo seleccionado
        const tipo = this.value;
        const categoriaSelect = document.getElementById('categoria_prenda');
        
        // Limpiar opciones anteriores
        categoriaSelect.innerHTML = '<option value="">Selecciona una categoría</option>';
        
        // === CATEGORÍAS PARA ROPA ===
        if (tipo === 'ropa') {
            const opciones = [
                'sudadera con capucha',
                'sudadera/jersey',
                'chaqueta',
                'camiseta',
                'pantalones vaqueros',
                'otros pantalones',
                'falda',
                'chandal'
            ];
            // Crea un <option> por cada categoría
            // charAt(0).toUpperCase() capitaliza la primera letra
            opciones.forEach(opcion => {
                categoriaSelect.innerHTML += `<option value="${opcion}">${opcion.charAt(0).toUpperCase() + opcion.slice(1)}</option>`;
            });
        } 
        // === CATEGORÍAS PARA CALZADO ===
        else if (tipo === 'calzado') {
            const opciones = [
                'zapato de vestir',
                'zapato skate',
                'playero de deporte',
                'chanclas',
                'zapatillas'
            ];
            opciones.forEach(opcion => {
                categoriaSelect.innerHTML += `<option value="${opcion}">${opcion.charAt(0).toUpperCase() + opcion.slice(1)}</option>`;
            });
        } 
        // === CATEGORÍAS PARA COMPLEMENTOS ===
        else if (tipo === 'complementos') {
            const opciones = [
                'playa',
                'montaña',
                'deportes exterior',
                
            ];
            opciones.forEach(opcion => {
                categoriaSelect.innerHTML += `<option value="${opcion}">${opcion.charAt(0).toUpperCase() + opcion.slice(1)}</option>`;
            });
        }
    });
</script>

@endsection