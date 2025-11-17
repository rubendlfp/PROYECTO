@extends('index')

@section('contenido_principal')
<style>
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

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.success-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.success-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.success-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    animation: fadeInUp 0.8s ease-out;
    overflow: hidden;
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 50px 40px;
    max-width: 600px;
    width: 100%;
}

.success-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    animation: bounceIn 1s ease-out 0.3s both;
    box-shadow: 0 15px 35px rgba(79, 172, 254, 0.3);
    position: relative;
}

.success-icon::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border-radius: 50%;
    z-index: -1;
    animation: pulse 2s ease-in-out infinite;
    opacity: 0.3;
}

.success-icon i {
    font-size: 3rem;
    color: white;
    animation: float 3s ease-in-out infinite;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    animation: fadeInUp 0.8s ease-out 0.5s both;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.success-message {
    font-size: 1.3rem;
    color: #5a6c7d;
    margin-bottom: 40px;
    animation: fadeInUp 0.8s ease-out 0.7s both;
    line-height: 1.6;
}

.order-details {
    background: linear-gradient(45deg, #a8edea, #fed6e3);
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 40px;
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

.back-btn {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    padding: 18px 40px;
    border-radius: 25px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    box-shadow: 0 15px 35px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s ease-out 1.1s both;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.back-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.back-btn:hover::before {
    left: 100%;
}

.back-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
    color: white;
    text-decoration: none;
}

.decorative-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 1;
}

.floating-element {
    position: absolute;
    opacity: 0.1;
    animation: float 4s ease-in-out infinite;
}

.floating-element:nth-child(1) {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-element:nth-child(2) {
    top: 60%;
    right: 15%;
    animation-delay: 1s;
}

.floating-element:nth-child(3) {
    bottom: 30%;
    left: 20%;
    animation-delay: 2s;
}
</style>

<div class="success-container">
    <div class="decorative-elements">
        <i class="fas fa-gift floating-element" style="font-size: 2rem;"></i>
        <i class="fas fa-star floating-element" style="font-size: 1.5rem;"></i>
        <i class="fas fa-heart floating-element" style="font-size: 1.8rem;"></i>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="success-card">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <h1 class="success-title">¡Pedido Realizado!</h1>
                    
                    <p class="success-message">
                        Gracias por comprar en nuestra tienda.<br>
                        Tu pedido ha sido procesado exitosamente.
                    </p>
                    
                    <div class="order-details">
                        <div class="order-number">
                            <i class="fas fa-receipt me-2"></i>
                            Número de pedido: #{{ str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="order-info">
                            <i class="fas fa-clock me-2"></i>
                            Fecha: {{ date('d/m/Y H:i') }}<br>
                            <i class="fas fa-truck me-2"></i>
                            Recibirás un email con los detalles de envío
                        </div>
                    </div>
                    
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