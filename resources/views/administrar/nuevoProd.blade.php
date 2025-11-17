@extends('index')

@section('contenido_principal')

<style>
        /* EDITAR */
    .div_editar {
        width: 25%;
        margin-left: 37%;
    }

    .input_imagen > input {
        display: none;
    }

    .editar_imagen {
        position: relative;
        width: 80%;
    }

    #boton_cancelar {
        margin-left: 40%;
    }

    #boton_guardar {
        position: absolute;
        margin-left: 2%;
    }
</style>

<div class="">
        
        <form id="confirmar" action="{{route('nuevoProd')}}" method="POST" enctype="multipart/form-data">
            @csrf

                <!-- {{-- Input imagen --}} -->
                <div  class="div_editar_img text-center">
                    <div class="input_imagen">
                        <label for="file-input">
                          <img class="editar_imagen img-responsive" src="{{asset('img/productos/default.jpg')}}"/>
                        </label>
                        <input onchange="mostrar_nueva_img(this)" id="file-input" type="file" name="nueva_imagen"/>
                      </div><br>
                </div>
                
                <!-- {{-- Input Titulo --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Titulo</span>
                        </div>
                        <input required type="text" class="form-control" name="titulo">
                        </div>
                    </div><br>
                </div>

                <!-- {{-- Input Descripcion --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Descripcion</span>
                        </div>
                        <input required type="text" class="form-control" name="descripcion">
                        </div>
                    </div><br>
                </div>

                <!-- {{-- Input Precio --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Precio</span>
                        </div>
                        <input required type="text" class="form-control" name="precio">
                        <div class="input-group-append">
                        <span class="input-group-text">€</span>
                        </div>
                    </div><br>
                </div>

                <!-- {{-- Input Valoracion --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Valoración</span>
                        </div>
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

                <!-- {{-- Input Tipo --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Tipo</span>
                        </div>
                        <select required name="tipo" class="form-control" id="tipo">
                            <option value="ropa">Ropa</option>
                            <option value="calzado">Calzado</option>
                            <option value="complementos">Complementos</option>
                        </select>
                    </div><br>
                </div>

                <!-- {{-- Input Marca --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Marca</span>
                        </div>
                        <input required type="text" class="form-control" name="marca">
                        </div>
                    </div><br>
                </div>

                <!-- {{-- Input Genero --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Genero</span>
                        </div>
                        <select required name="genero" class="form-control" id="genero">
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="unisex">Unisex</option>
                        </select>
                    </div><br>
                </div>

                <!-- {{-- Input Categoria Prenda --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Categoria</span>
                        </div>
                        <select required name="categoria_prenda" class="form-control" id="categoria_prenda">
                            <option value="">Selecciona una categoría</option>
                            <!-- Opciones se llenarán dinámicamente con JavaScript -->
                        </select>
                    </div><br>
                </div>

                <!-- {{-- Input img2 --}} -->
                <div class="div_editar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Imagen 2</span>
                        </div>
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
                        <input type="file" class="form-control" name="img4">
                        </div>
                    </div><br>
                </div>
                            
                <br>
                <div>
                    <a href="{{route('administrar')}}"><input type="button" id="boton_cancelar" class="btn btn-danger" value="Cancelar"></a>
                    <button id="boton_guardar" class="btn btn-info">Guardar</button>
                </div>
            </form>
        </div>
        <div style="height: 40px;"></div>

    <script>
        function mostrar_nueva_img(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.editar_imagen').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }

        // Script para cambiar las opciones de categoría según el tipo seleccionado
        document.getElementById('tipo').addEventListener('change', function() {
            const tipo = this.value;
            const categoriaSelect = document.getElementById('categoria_prenda');
            
            // Limpiar opciones anteriores
            categoriaSelect.innerHTML = '<option value="">Selecciona una categoría</option>';
            
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
                opciones.forEach(opcion => {
                    categoriaSelect.innerHTML += `<option value="${opcion}">${opcion.charAt(0).toUpperCase() + opcion.slice(1)}</option>`;
                });
            } else if (tipo === 'calzado') {
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
            } else if (tipo === 'complementos') {
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