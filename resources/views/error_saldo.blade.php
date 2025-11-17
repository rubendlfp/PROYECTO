@extends('index')

@section('contenido_principal')
<style>
    .error-saldo-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin-top: -20px;
    }

    .error-card {
        background: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        text-align: center;
        animation: slideIn 0.5s ease-out;
    }

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

    .error-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .error-icon i {
        font-size: 60px;
        color: white;
    }

    .error-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .error-subtitle {
        font-size: 1.5rem;
        color: #f5576c;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .error-message {
        color: #718096;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

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

    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        color: white;
        text-decoration: none;
    }

    .info-box {
        background: #f7fafc;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        margin-top: 2rem;
        border-radius: 8px;
        text-align: left;
    }

    .info-box h4 {
        color: #2d3748;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    .info-box ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .info-box li {
        color: #4a5568;
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
    }

    .info-box li i {
        color: #667eea;
        margin-right: 10px;
        font-size: 1.2rem;
    }

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

<div class="error-saldo-container">
    <div class="error-card">
        <!-- Icono de Error -->
        <div class="error-icon">
            <i class="fas fa-wallet"></i>
        </div>

        <!-- Título Principal -->
        <h1 class="error-title">¡Oops!</h1>
        
        <!-- Subtítulo -->
        <h2 class="error-subtitle">Saldo Insuficiente</h2>

        <!-- Mensaje -->
        <p class="error-message">
            Lo sentimos, no tienes saldo suficiente para completar esta compra. 
            Por favor, recarga tu cuenta o elige productos de menor valor.
        </p>

        <!-- Botón Principal -->
        <a href="{{ route('principal') }}" class="btn-custom">
            <i class="fas fa-home me-2"></i>Volver al Inicio
        </a>

        <!-- Información Adicional -->
        <div class="info-box">
            <h4><i class="fas fa-lightbulb me-2"></i>¿Qué puedes hacer?</h4>
            <ul>
                <li>
                    <i class="fas fa-credit-card"></i>
                    <span>Recargar tu cuenta con más saldo</span>
                </li>
                <li>
                    <i class="fas fa-shopping-cart"></i>
                    <span>Revisar tu carrito y ajustar cantidades</span>
                </li>
                <li>
                    <i class="fas fa-tags"></i>
                    <span>Buscar productos con descuento</span>
                </li>
                <li>
                    <i class="fas fa-headset"></i>
                    <span>Contactar con soporte si necesitas ayuda</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection