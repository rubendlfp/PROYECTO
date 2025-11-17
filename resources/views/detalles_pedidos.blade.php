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

.payment-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 60px 0;
    position: relative;
    overflow: hidden;
}

.payment-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.payment-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    animation: fadeInUp 0.8s ease-out;
    overflow: hidden;
    position: relative;
    z-index: 2;
}

.payment-header {
    background: linear-gradient(45deg, #ff9a9e, #fecfef);
    padding: 30px;
    text-align: center;
    color: white;
    position: relative;
}

.payment-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.payment-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    z-index: 2;
}

.payment-subtitle {
    font-size: 1.1rem;
    margin-top: 10px;
    opacity: 0.9;
    position: relative;
    z-index: 2;
}

.payment-body {
    padding: 40px;
}

.form-group {
    margin-bottom: 25px;
    animation: slideInLeft 0.6s ease-out;
}

.form-group:nth-child(2) { animation-delay: 0.1s; }
.form-group:nth-child(3) { animation-delay: 0.2s; }
.form-group:nth-child(4) { animation-delay: 0.3s; }

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.95rem;
    display: block;
}

.modern-input {
    border: 2px solid #e0e6ed;
    border-radius: 15px;
    padding: 15px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.modern-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
}

.modern-input::placeholder {
    color: #a0aec0;
}

.payment-summary {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
}

.total-amount {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

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

.payment-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.payment-btn:hover::before {
    left: 100%;
}

.payment-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
    color: white;
}

.security-notice {
    background: linear-gradient(45deg, #a8edea, #fed6e3);
    padding: 20px;
    border-radius: 15px;
    margin-top: 25px;
    text-align: center;
    color: #2c3e50;
}

.security-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #27ae60;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}
</style>

<div class="payment-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="payment-card">
                    <div class="payment-header">
                        <h1 class="payment-title">
                            <i class="fas fa-credit-card me-3"></i>Finalizar Compra
                        </h1>
                        <p class="payment-subtitle">Complete sus datos para proceder con el pago</p>
                    </div>
                    
                    <div class="payment-body">
                        <div class="payment-summary">
                            <h3 class="total-amount">
                                <i class="fas fa-euro-sign me-2"></i>{{$precioTotal}}
                            </h3>
                            <p class="mb-0">Total a pagar</p>
                        </div>

                        <form action="{{ route('guardarDetallesPedido', $precioTotal) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user me-2"></i>Nombre Completo
                                        </label>
                                        <input name="nombre" class="form-control modern-input" type="text" placeholder="Ingrese su nombre completo" required>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i>Dirección
                                        </label>
                                        <input name="direccion" class="form-control modern-input" type="text" placeholder="Calle, número, apartamento..." required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-flag me-2"></i>País
                                        </label>
                                        <input name="pais" class="form-control modern-input" type="text" placeholder="País" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-city me-2"></i>Ciudad
                                        </label>
                                        <input name="ciudad" class="form-control modern-input" type="text" placeholder="Ciudad" required>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="precio_totad" id="precio_total" value="{{$precioTotal}}">
                                
                                <div class="col-12">
                                    <button type="submit" class="payment-btn">
                                        <i class="fas fa-lock me-2"></i>Confirmar Pago - {{$precioTotal}}€
                                    </button>
                                </div>
                            </div>
                        </form>

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