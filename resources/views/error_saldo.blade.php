{{--
===========================================
VISTA: Error de Saldo Insuficiente
===========================================
Propósito: Página de error cuando el usuario no tiene saldo suficiente para completar compra
Acceso: Usuarios autenticados redirigidos desde el proceso de pago
Funcionalidad: Informar sobre saldo insuficiente y proporcionar opciones alternativas
Ruta: /error-saldo (o similar según configuración de rutas)
--}}

@extends('index')

@section('contenido_principal')

{{-- === ESTILOS PERSONALIZADOS === --}}
<style>
    /* === CONTENEDOR PRINCIPAL === */
    /* Contenedor de página completa con gradiente púrpura */
    .error-saldo-container {
        min-height: 80vh;
        /* Centrado vertical y horizontal con flexbox */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        /* Elimina margen superior para fondo continuo */
        margin-top: -20px;
    }

    /* === TARJETA DE ERROR === */
    /* Tarjeta blanca centrada con sombra pronunciada */
    .error-card {
        background: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        text-align: center;
        /* Animación de entrada */
        animation: slideIn 0.5s ease-out;
    }

    /* === ANIMACIÓN SLIDE IN === */
    /* Entrada desde arriba con fade */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* === ÍCONO DE ERROR === */
    /* Círculo con gradiente rosa/rojo y animación de pulsación */
    .error-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 50%;
        /* Centrado del ícono dentro del círculo */
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    /* === ANIMACIÓN PULSE === */
    /* Pulsación suave continua */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    /* Ícono de cartera dentro del círculo */
    .error-icon i {
        font-size: 60px;
        color: white;
    }

    /* === TÍTULO PRINCIPAL === */
    .error-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 1rem;
        text-transform: uppercase;
        /* Espaciado entre letras */
        letter-spacing: 1px;
    }

    /* === SUBTÍTULO === */
    /* Mensaje de error en color rojo/rosa */
    .error-subtitle {
        font-size: 1.5rem;
        color: #f5576c;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    /* === MENSAJE DE ERROR === */
    /* Texto explicativo en gris */
    .error-message {
        color: #718096;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    /* === BOTÓN PERSONALIZADO === */
    /* Botón con gradiente púrpura y efectos hover */
    .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Efecto de elevación al hover */
    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        color: white;
        text-decoration: none;
    }

    /* === CAJA DE INFORMACIÓN === */
    /* Contenedor de sugerencias con borde lateral púrpura */
    .info-box {
        background: #f7fafc;
        /* Borde izquierdo destacado */
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        margin-top: 2rem;
        border-radius: 8px;
        /* Alineación a la izquierda para la lista */
        text-align: left;
    }

    /* Título de la caja de información */
    .info-box h4 {
        color: #2d3748;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    /* Lista sin viñetas por defecto */
    .info-box ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    /* Items de la lista con íconos */
    .info-box li {
        color: #4a5568;
        padding: 0.5rem 0;
        /* Alineación con ícono */
        display: flex;
        align-items: center;
    }

    /* Íconos de las opciones */
    .info-box li i {
        color: #667eea;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    /* === RESPONSIVE === */
    /* Ajustes para dispositivos móviles */
    @media (max-width: 768px) {
        .error-title {
            font-size: 2rem;
        }
        
        .error-subtitle {
            font-size: 1.2rem;
        }
        
        .error-card {
            padding: 2rem 1.5rem;
        }
    }
</style>

{{-- === CONTENEDOR PRINCIPAL === --}}
<div class="error-saldo-container">
    <div class="error-card">
        {{-- === ÍCONO DE ERROR === --}}
        <!-- Icono de Error -->
        <div class="error-icon">
            {{-- Ícono de cartera para representar problemas de saldo --}}
            <i class="fas fa-wallet"></i>
        </div>

        {{-- === TÍTULO PRINCIPAL === --}}
        <!-- Título Principal -->
        <h1 class="error-title">¡Oops!</h1>
        
        {{-- === SUBTÍTULO === --}}
        <!-- Subtítulo -->
        <h2 class="error-subtitle">Saldo Insuficiente</h2>

        {{-- === MENSAJE EXPLICATIVO === --}}
        <!-- Mensaje -->
        <p class="error-message">
            Lo sentimos, no tienes saldo suficiente para completar esta compra. 
            Por favor, recarga tu cuenta o elige productos de menor valor.
        </p>

        {{-- === BOTÓN PRINCIPAL === --}}
        <!-- Botón Principal -->
        {{-- Redirección a la página principal usando helper route() --}}
        <a href="{{ route('principal') }}" class="btn-custom">
            <i class="fas fa-home me-2"></i>Volver al Inicio
        </a>

        {{-- === INFORMACIÓN ADICIONAL === --}}
        <!-- Información Adicional -->
        <div class="info-box">
            <h4><i class="fas fa-lightbulb me-2"></i>¿Qué puedes hacer?</h4>
            <ul>
                {{-- Opción 1: Recargar saldo --}}
                <li>
                    <i class="fas fa-credit-card"></i>
                    <span>Recargar tu cuenta con más saldo</span>
                </li>
                {{-- Opción 2: Ajustar carrito --}}
                <li>
                    <i class="fas fa-shopping-cart"></i>
                    <span>Revisar tu carrito y ajustar cantidades</span>
                </li>
                {{-- Opción 3: Buscar descuentos --}}
                <li>
                    <i class="fas fa-tags"></i>
                    <span>Buscar productos con descuento</span>
                </li>
                {{-- Opción 4: Soporte --}}
                <li>
                    <i class="fas fa-headset"></i>
                    <span>Contactar con soporte si necesitas ayuda</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection