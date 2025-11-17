{{--
===========================================
LAYOUT PRINCIPAL: index.blade.php
===========================================
Propósito: Template base que contiene la estructura HTML común para todas las páginas
Componentes: Header con navegación, área de contenido dinámico (@yield), Footer
Funcionalidad: Navegación principal, menú de administrador, contador de carrito, enlaces a redes sociales
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    {{-- === META TAGS === --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    {{-- === CDN DE FONT AWESOME 6.1.1 === --}}
    {{-- Iconos para toda la aplicación --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    {{-- === BOOTSTRAP 5.1.3 CSS === --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    {{-- === ARCHIVOS CSS Y JS PERSONALIZADOS === --}}
    {{-- JavaScript personalizado para filtros --}}
    <script type="text/javascript" src="{{ asset('js/filtros/js.js') }}"></script>
    {{-- Hojas de estilo personalizadas --}}
    <link rel="stylesheet" href="{{ asset('css/filtros/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detalles_pedido/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagina_principal/style.css') }}">
    
    {{-- === BOOTSTRAP 5.0.2 JS BUNDLE === --}}
    {{-- Incluye Popper.js para funcionalidades de dropdown/tooltips --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    {{-- === HEADER === --}}
    <header>
        {{-- Barra de navegación fija en la parte superior con fondo oscuro --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-lg">
            <div class="container">
                {{-- === LOGO/MARCA === --}}
                <a class="navbar-brand fw-bold fs-4" href="{{ route('principal') }}">
                    <i class="fa-solid fa-store me-2"></i>INICIO
                </a>
                
                {{-- Botón hamburguesa para móvil --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                {{-- === MENÚ DE NAVEGACIÓN === --}}
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto align-items-center">
                        {{-- Link: Todos los productos --}}
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('comprar') }}">
                                <i class="fa-solid fa-box me-1"></i>Productos
                            </a>
                        </li>
                        {{-- Link: Productos de Hombre --}}
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('comprarHombre') }}">
                                <i class="fa-solid fa-person me-1"></i>Hombre
                            </a>
                        </li>
                        {{-- Link: Productos de Mujer --}}
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('comprarMujer') }}">
                                <i class="fa-solid fa-person-dress me-1"></i>Mujer
                            </a>
                        </li>
                        {{-- Link: Compraventa --}}
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('compraventa') }}" data-toggle="tooltip"
                                data-placement="bottom" title="Compraventa">
                                <i class="fa-solid fa-exchange-alt me-1"></i>Compraventa
                            </a>
                        </li>
                        
                        {{-- === MENÚ DE ADMINISTRADOR === --}}
                        {{-- Solo visible para usuarios autenticados con tipo_usuario == 1 --}}
                        @auth
                            @if(auth()->user()->tipo_usuario == 1)
                                <li class="nav-item dropdown">
                                    {{-- Dropdown en color amarillo para destacar rol de admin --}}
                                    <a class="nav-link dropdown-toggle px-3 text-warning fw-semibold" href="#" id="adminDropdown" 
                                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-shield-halved me-1"></i>Admin
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="adminDropdown">
                                        {{-- Opción: Administrar Productos --}}
                                        <li>
                                            <a class="dropdown-item" href="{{ route('administrar') }}">
                                                <i class="fa-solid fa-cog me-2 text-primary"></i>Productos
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        {{-- Opción: Administrar Compraventa --}}
                                        <li>
                                            <a class="dropdown-item" href="{{ route('compraventa_administrar') }}">
                                                <i class="fa-solid fa-tools me-2 text-danger"></i>Compraventa
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        {{-- Opción: Administrar Pedidos --}}
                                        <li>
                                            <a class="dropdown-item" href="{{ route('administrarPedidos') }}">
                                                <i class="fa-solid fa-receipt me-2 text-success"></i>Pedidos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                        
                        {{-- === LINK PERFIL/LOGIN === --}}
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('login') }}" data-toggle="tooltip"
                                data-placement="bottom" title="Perfil">
                                <i class="fa-solid fa-user fs-5"></i>
                            </a>
                        </li>
                        
                        {{-- === CARRITO CON CONTADOR === --}}
                        <li class="nav-item">
                            <a class="nav-link px-3 position-relative" href="{{ route('mostrarProductoCarrito') }}" 
                               data-toggle="tooltip" data-placement="bottom" title="Carrito">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                {{-- Badge con cantidad de productos (solo usuarios autenticados) --}}
                                @auth
                                    @php
                                        // Calcula la suma total de cantidades en el carrito del usuario
                                        $totalCarrito = \App\Models\carritoCompra::where('id_user', auth()->id())->sum('cantidad');
                                    @endphp
                                    @if($totalCarrito > 0)
                                        {{-- Badge rojo con número de productos --}}
                                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $totalCarrito }}
                                        </span>
                                    @endif
                                @endauth
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- === CONTENIDO PRINCIPAL === --}}
    <main>
        {{-- Espaciador para compensar navbar fixed-top (56px de altura) --}}
        <div style="height: 56px;"></div>
        {{-- Sección de contenido dinámico que será reemplazada por cada vista --}}
        @yield('contenido_principal')
    </main>


    {{-- === FOOTER === --}}
    <footer class="bg-gradient text-white" style="position: relative; bottom:0px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <!-- Grid container -->
        <div class="container py-5">
            <div class="row g-4">
                {{-- === COLUMNA 1: INFORMACIÓN DE LA EMPRESA === --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Mi Tienda Online
                    </h5>
                    <p class="text-light mb-3">
                        Tu destino de compras online favorito. Ofrecemos productos de calidad con la mejor atención al cliente.
                    </p>
                    {{-- Información de contacto --}}
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>Madrid, España</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <span>+34 123 456 789</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <span>info@mitienda.com</span>
                    </div>
                </div>

                {{-- === COLUMNA 2: ENLACES ÚTILES === --}}
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Enlaces Útiles</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-angle-right me-1"></i>Inicio
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-angle-right me-1"></i>Productos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-angle-right me-1"></i>Ofertas
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-angle-right me-1"></i>Contacto
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- === COLUMNA 3: SERVICIO AL CLIENTE === --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Servicio al Cliente</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-question-circle me-1"></i>Ayuda y Soporte
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-undo me-1"></i>Devoluciones
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-shipping-fast me-1"></i>Envíos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none">
                                <i class="fas fa-shield-alt me-1"></i>Política de Privacidad
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- === COLUMNA 4: REDES SOCIALES Y NEWSLETTER === --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Síguenos</h6>
                    <div class="mb-3">
                        {{-- Botones circulares para redes sociales --}}
                        <!-- Facebook -->
                        <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="https://www.facebook.com"
                            role="button" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <!-- Instagram -->
                        <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="https://www.instagram.com"
                            role="button" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <!-- Twitter -->
                        <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="https://twitter.com"
                            role="button" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <!-- LinkedIn -->
                        <a class="btn btn-outline-light btn-floating m-1 rounded-circle" href="#!"
                            role="button" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    {{-- Formulario de newsletter --}}
                    <h6 class="fw-bold mb-3">Newsletter</h6>
                    <p class="text-light mb-2" style="font-size: 0.9rem;">
                        Suscríbete para recibir ofertas exclusivas
                    </p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Tu email" aria-label="Email">
                        <button class="btn btn-light" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Divisor --}}
            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.3);">

            {{-- === MÉTODOS DE PAGO === --}}
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2">Métodos de Pago Seguros</h6>
                    <div class="d-flex flex-wrap">
                        {{-- Iconos de tarjetas de crédito con colores corporativos --}}
                        <i class="fab fa-cc-visa fa-2x me-3 mb-2" style="color: #1A1F71;"></i>
                        <i class="fab fa-cc-mastercard fa-2x me-3 mb-2" style="color: #EB001B;"></i>
                        <i class="fab fa-cc-paypal fa-2x me-3 mb-2" style="color: #003087;"></i>
                        <i class="fas fa-credit-card fa-2x me-3 mb-2" style="color: #28a745;"></i>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    {{-- Indicador de compra segura --}}
                    <div class="d-flex justify-content-md-end align-items-center">
                        <i class="fas fa-shield-alt me-2" style="color: #28a745;"></i>
                        <span class="text-light">Compra 100% Segura</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- === COPYRIGHT === --}}
        <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.3); border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="container">
                <div class="row align-items-center">
                    {{-- Información de copyright --}}
                    <div class="col-md-6 text-md-start">
                        © 2025 <strong>Rubén de la Fuente</strong>. Todos los derechos reservados.
                    </div>
                    {{-- Mensaje personalizado --}}
                    <div class="col-md-6 text-md-end">
                        <small>
                            Hecho con <i class="fas fa-heart text-danger"></i> en España
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>