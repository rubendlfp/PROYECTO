{{--
===========================================
VISTA: Página de Agradecimiento
===========================================
Propósito: Confirmación visual de pedido exitoso
Acceso: Usuarios autenticados que completan una compra
Funcionalidad: Muestra mensaje de éxito con animaciones y detalles del pedido
Ruta: /agradecimiento (después de completar compra)
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS Y ANIMACIONES === --}}
<style>
/* === ANIMACIÓN: Entrada desde abajo === */
@keyframes fadeInUp {
    from {
        /* Comienza invisible y desplazado hacia abajo */
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        /* Termina visible y en posición original */
        opacity: 1;
        transform: translateY(0);
    }
}

/* === ANIMACIÓN: Rebote al entrar === */
@keyframes bounceIn {
    0% {
        /* Empieza invisible y pequeño */
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        /* Se expande un poco más de lo normal */
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        /* Se contrae ligeramente */
        transform: scale(0.9);
    }
    100% {
        /* Vuelve al tamaño normal */
        opacity: 1;
        transform: scale(1);
    }
}

/* === ANIMACIÓN: Pulso suave === */
@keyframes pulse {
    0%, 100% {
        /* Tamaño normal al inicio y final */
        transform: scale(1);
    }
    50% {
        /* Ligeramente más grande en el medio */
        transform: scale(1.05);
    }
}

/* === ANIMACIÓN: Flotación === */
@keyframes float {
    0%, 100% {
        /* Posición original al inicio y final */
        transform: translateY(0px);
    }
    50% {
        /* Sube 10px en el medio del ciclo */
        transform: translateY(-10px);
    }
}

/* === CONTENEDOR PRINCIPAL === */
.success-container {
    /* Gradiente púrpura de fondo */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* Ocupa toda la altura de la ventana */
    min-height: 100vh;
    /* Centra contenido horizontal y verticalmente */
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    /* Oculta elementos que se salgan */
    overflow: hidden;
}

/* === TEXTURA DE FONDO === */
.success-container::before {
    content: '';
    /* Cubre todo el contenedor */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* Patrón SVG inline de puntos para textura */
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    /* Semi-transparente */
    opacity: 0.3;
}

/* === TARJETA DE ÉXITO === */
.success-card {
    /* Fondo blanco semi-transparente */
    background: rgba(255, 255, 255, 0.95);
    /* Efecto de desenfoque del fondo */
    backdrop-filter: blur(20px);
    /* Borde sutil semi-transparente */
    border: 1px solid rgba(255, 255, 255, 0.2);
    /* Esquinas muy redondeadas */
    border-radius: 25px;
    /* Sombra pronunciada */
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    /* Animación de entrada desde abajo en 0.8s */
    animation: fadeInUp 0.8s ease-out;
    overflow: hidden;
    position: relative;
    /* Sobre los elementos decorativos */
    z-index: 2;
    text-align: center;
    /* Espaciado interno generoso */
    padding: 50px 40px;
    max-width: 600px;
    width: 100%;
}

/* === ÍCONO DE ÉXITO === */
.success-icon {
    /* Círculo de 120px */
    width: 120px;
    height: 120px;
    /* Gradiente azul */
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border-radius: 50%;
    /* Centra el ícono dentro */
    display: flex;
    align-items: center;
    justify-content: center;
    /* Centrado horizontalmente */
    margin: 0 auto 30px;
    /* Animación de rebote con retraso de 0.3s */
    animation: bounceIn 1s ease-out 0.3s both;
    /* Sombra azul */
    box-shadow: 0 15px 35px rgba(79, 172, 254, 0.3);
    position: relative;
}

/* === HALO PULSANTE DEL ÍCONO === */
.success-icon::before {
    content: '';
    /* Halo más grande que el ícono */
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    /* Mismo gradiente que el ícono */
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border-radius: 50%;
    /* Detrás del ícono */
    z-index: -1;
    /* Pulso infinito cada 2 segundos */
    animation: pulse 2s ease-in-out infinite;
    /* Semi-transparente */
    opacity: 0.3;
}

.success-icon i {
    /* Ícono grande */
    font-size: 3rem;
    color: white;
    /* Flotación infinita cada 3 segundos */
    animation: float 3s ease-in-out infinite;
}

/* === TÍTULO === */
.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    /* Animación con retraso de 0.5s */
    animation: fadeInUp 0.8s ease-out 0.5s both;
    /* Gradiente aplicado al texto */
    background: linear-gradient(45deg, #667eea, #764ba2);
    /* Permite que el gradiente se aplique al texto */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* === MENSAJE === */
.success-message {
    font-size: 1.3rem;
    color: #5a6c7d;
    margin-bottom: 40px;
    /* Animación con retraso de 0.7s */
    animation: fadeInUp 0.8s ease-out 0.7s both;
    /* Altura de línea para mejor legibilidad */
    line-height: 1.6;
}

/* === DETALLES DEL PEDIDO === */
.order-details {
    /* Gradiente rosa/turquesa de fondo */
    background: linear-gradient(45deg, #a8edea, #fed6e3);
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 40px;
    /* Animación con retraso de 0.9s */
    animation: fadeInUp 0.8s ease-out 0.9s both;
}

.order-number {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.order-info {
    color: #5a6c7d;
    font-size: 0.95rem;
}

/* === BOTÓN DE REGRESO === */
.back-btn {
    /* Gradiente rojo/naranja */
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    /* Botón grande y llamativo */
    padding: 18px 40px;
    border-radius: 25px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    /* Sombra roja */
    box-shadow: 0 15px 35px rgba(255, 107, 107, 0.3);
    /* Transición suave para hover */
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    /* Animación con retraso de 1.1s */
    animation: fadeInUp 0.8s ease-out 1.1s both;
    /* Flexbox para alinear ícono y texto */
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

/* === EFECTO BRILLO EN BOTÓN === */
.back-btn::before {
    content: '';
    position: absolute;
    top: 0;
    /* Comienza fuera del botón a la izquierda */
    left: -100%;
    width: 100%;
    height: 100%;
    /* Gradiente que simula brillo */
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    /* Transición del movimiento del brillo */
    transition: left 0.5s;
}

.back-btn:hover::before {
    /* El brillo cruza hacia la derecha al hover */
    left: 100%;
}

.back-btn:hover {
    /* Se eleva al pasar cursor */
    transform: translateY(-3px);
    /* Sombra más pronunciada */
    box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
    color: white;
    text-decoration: none;
}

/* === ELEMENTOS DECORATIVOS === */
.decorative-elements {
    /* Cubre todo el contenedor */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* No interfiere con clics */
    pointer-events: none;
    /* Detrás de la tarjeta */
    z-index: 1;
}

.floating-element {
    position: absolute;
    /* Semi-transparente */
    opacity: 0.1;
    /* Flotación de 4 segundos */
    animation: float 4s ease-in-out infinite;
}

/* === POSICIONES Y DELAYS DE ELEMENTOS FLOTANTES === */
.floating-element:nth-child(1) {
    top: 20%;
    left: 10%;
    /* Sin retraso */
    animation-delay: 0s;
}

.floating-element:nth-child(2) {
    top: 60%;
    right: 15%;
    /* Retraso de 1s */
    animation-delay: 1s;
}

.floating-element:nth-child(3) {
    bottom: 30%;
    left: 20%;
    /* Retraso de 2s */
    animation-delay: 2s;
}
</style>

{{-- === CONTENIDO HTML === --}}
<div class="success-container">
    {{-- === ELEMENTOS DECORATIVOS FLOTANTES === --}}
    {{-- Íconos que flotan en el fondo con animación --}}
    <div class="decorative-elements">
        {{-- Regalo flotante --}}
        <i class="fas fa-gift floating-element" style="font-size: 2rem;"></i>
        {{-- Estrella flotante --}}
        <i class="fas fa-star floating-element" style="font-size: 1.5rem;"></i>
        {{-- Corazón flotante --}}
        <i class="fas fa-heart floating-element" style="font-size: 1.8rem;"></i>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                {{-- === TARJETA PRINCIPAL DE ÉXITO === --}}
                <div class="success-card">
                    {{-- Ícono de check con animación de rebote --}}
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    {{-- Título con gradiente de texto --}}
                    <h1 class="success-title">¡Pedido Realizado!</h1>
                    
                    {{-- Mensaje de agradecimiento --}}
                    <p class="success-message">
                        Gracias por comprar en nuestra tienda.<br>
                        Tu pedido ha sido procesado exitosamente.
                    </p>
                    
                    {{-- === DETALLES DEL PEDIDO === --}}
                    <div class="order-details">
                        {{-- Número de pedido aleatorio formateado --}}
                        <div class="order-number">
                            <i class="fas fa-receipt me-2"></i>
                            {{-- rand() genera número aleatorio entre 1000-9999 --}}
                            {{-- str_pad() rellena con ceros si es necesario --}}
                            Número de pedido: #{{ str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) }}
                        </div>
                        {{-- Información adicional del pedido --}}
                        <div class="order-info">
                            <i class="fas fa-clock me-2"></i>
                            {{-- Fecha y hora actual en formato español --}}
                            Fecha: {{ date('d/m/Y H:i') }}<br>
                            <i class="fas fa-truck me-2"></i>
                            Recibirás un email con los detalles de envío
                        </div>
                    </div>
                    
                    {{-- Botón para volver a la página principal --}}
                    <a href="{{ route('principal') }}" class="back-btn">
                        <i class="fas fa-home"></i>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection