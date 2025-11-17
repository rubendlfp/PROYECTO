{{--
===========================================
VISTA: Detalles de Pedido / Pago
===========================================
Propósito: Formulario para capturar datos de envío y confirmar el pago
Acceso: Usuarios autenticados con carrito activo
Funcionalidad: Formulario de datos personales y dirección para finalizar compra
Ruta: /pagar/{precioTotal}
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
/* === ANIMACIÓN FADE IN UP === */
/* Aparición desde abajo con fade */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* === ANIMACIÓN SLIDE IN LEFT === */
/* Aparición desde la izquierda con fade */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* === CONTENEDOR PRINCIPAL === */
/* Contenedor con gradiente púrpura de fondo completo */
.payment-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 60px 0;
    position: relative;
    overflow: hidden;
}

/* Textura de grano SVG sobre el fondo */
.payment-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* SVG inline con patrón de círculos para textura */
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

/* === TARJETA DE PAGO === */
/* Tarjeta principal con glassmorphism */
.payment-card {
    /* Fondo blanco semi-transparente */
    background: rgba(255, 255, 255, 0.95);
    /* Efecto de desenfoque del fondo */
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    /* Animación de entrada */
    animation: fadeInUp 0.8s ease-out;
    overflow: hidden;
    position: relative;
    z-index: 2;
}

/* === ENCABEZADO DE PAGO === */
/* Header con gradiente rosa suave */
.payment-header {
    background: linear-gradient(45deg, #ff9a9e, #fecfef);
    padding: 30px;
    text-align: center;
    color: white;
    position: relative;
}

/* Efecto de luz radial animado en el header */
.payment-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    /* Gradiente radial para efecto de brillo */
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    /* Animación de pulsación */
    animation: pulse 4s ease-in-out infinite;
}

/* === TÍTULO DE PAGO === */
.payment-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    z-index: 2;
}

/* Subtítulo descriptivo */
.payment-subtitle {
    font-size: 1.1rem;
    margin-top: 10px;
    opacity: 0.9;
    position: relative;
    z-index: 2;
}

/* === CUERPO DEL FORMULARIO === */
.payment-body {
    padding: 40px;
}

/* === GRUPOS DE FORMULARIO === */
/* Espacio entre campos con animación de entrada */
.form-group {
    margin-bottom: 25px;
    /* Animación desde la izquierda */
    animation: slideInLeft 0.6s ease-out;
}

/* Retrasos escalonados para efecto cascada */
.form-group:nth-child(2) { animation-delay: 0.1s; }
.form-group:nth-child(3) { animation-delay: 0.2s; }
.form-group:nth-child(4) { animation-delay: 0.3s; }

/* === ETIQUETAS DE FORMULARIO === */
.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.95rem;
    display: block;
}

/* === INPUTS MODERNOS === */
/* Campos de entrada con estilo glassmorphism */
.modern-input {
    border: 2px solid #e0e6ed;
    border-radius: 15px;
    padding: 15px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
    /* Fondo semi-transparente */
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

/* Efecto al enfocar input */
.modern-input:focus {
    outline: none;
    /* Borde púrpura */
    border-color: #667eea;
    /* Sombra de enfoque */
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: rgba(255, 255, 255, 0.95);
    /* Leve elevación */
    transform: translateY(-2px);
}

/* Estilo del placeholder */
.modern-input::placeholder {
    color: #a0aec0;
}

/* === RESUMEN DE PAGO === */
/* Tarjeta de resumen con gradiente azul cyan */
.payment-summary {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
}

/* Cantidad total destacada */
.total-amount {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

/* === BOTÓN DE PAGO === */
/* Botón principal con gradiente rojo y efecto de brillo */
.payment-btn {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    padding: 18px 40px;
    border-radius: 25px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    width: 100%;
    text-decoration: none;
    box-shadow: 0 15px 35px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

/* Efecto de brillo animado que cruza el botón */
.payment-btn::before {
    content: '';
    position: absolute;
    top: 0;
    /* Comienza fuera del botón por la izquierda */
    left: -100%;
    width: 100%;
    height: 100%;
    /* Gradiente de brillo horizontal */
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

/* Anima el brillo al hover */
.payment-btn:hover::before {
    /* Cruza hacia la derecha */
    left: 100%;
}

/* Efecto de elevación al hover */
.payment-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
    color: white;
}

/* === AVISO DE SEGURIDAD === */
/* Badge de seguridad con gradiente pastel */
.security-notice {
    background: linear-gradient(45deg, #a8edea, #fed6e3);
    padding: 20px;
    border-radius: 15px;
    margin-top: 25px;
    text-align: center;
    color: #2c3e50;
}

/* Ícono de escudo */
.security-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #27ae60;
}

/* === ANIMACIÓN PULSE === */
/* Animación de pulsación para el header */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}
</style>

{{-- === CONTENEDOR PRINCIPAL === --}}
<div class="payment-container">
    <div class="container">
        {{-- Centrado responsivo --}}
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                {{-- === TARJETA DE PAGO === --}}
                <div class="payment-card">
                    {{-- === ENCABEZADO === --}}
                    <div class="payment-header">
                        <h1 class="payment-title">
                            <i class="fas fa-credit-card me-3"></i>Finalizar Compra
                        </h1>
                        <p class="payment-subtitle">Complete sus datos para proceder con el pago</p>
                    </div>
                    
                    {{-- === CUERPO DEL FORMULARIO === --}}
                    <div class="payment-body">
                        {{-- === RESUMEN DE TOTAL === --}}
                        <div class="payment-summary">
                            <h3 class="total-amount">
                                {{-- Muestra el precio total recibido como parámetro --}}
                                <i class="fas fa-euro-sign me-2"></i>{{$precioTotal}}
                            </h3>
                            <p class="mb-0">Total a pagar</p>
                        </div>

                        {{-- === FORMULARIO DE DETALLES === --}}
                        {{-- POST a ruta que guarda detalles y procesa pedido --}}
                        <form action="{{ route('guardarDetallesPedido', $precioTotal) }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- === CAMPO NOMBRE === --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user me-2"></i>Nombre Completo
                                        </label>
                                        {{-- Input requerido para el nombre --}}
                                        <input name="nombre" class="form-control modern-input" type="text" placeholder="Ingrese su nombre completo" required>
                                    </div>
                                </div>
                                
                                {{-- === CAMPO DIRECCIÓN === --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i>Dirección
                                        </label>
                                        <input name="direccion" class="form-control modern-input" type="text" placeholder="Calle, número, apartamento..." required>
                                    </div>
                                </div>
                                
                                {{-- === CAMPO PAÍS === --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-flag me-2"></i>País
                                        </label>
                                        <input name="pais" class="form-control modern-input" type="text" placeholder="País" required>
                                    </div>
                                </div>
                                
                                {{-- === CAMPO CIUDAD === --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-city me-2"></i>Ciudad
                                        </label>
                                        <input name="ciudad" class="form-control modern-input" type="text" placeholder="Ciudad" required>
                                    </div>
                                </div>
                                
                                {{-- Campo oculto con el precio total --}}
                                {{-- Nota: typo en name "precio_totad" (debería ser "precio_total") --}}
                                <input type="hidden" name="precio_totad" id="precio_total" value="{{$precioTotal}}">
                                
                                {{-- === BOTÓN CONFIRMAR === --}}
                                <div class="col-12">
                                    <button type="submit" class="payment-btn">
                                        <i class="fas fa-lock me-2"></i>Confirmar Pago - {{$precioTotal}}€
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- === AVISO DE SEGURIDAD === --}}
                        <div class="security-notice">
                            <div class="security-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <strong>Pago Seguro</strong><br>
                            Sus datos están protegidos con encriptación SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection