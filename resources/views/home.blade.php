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

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.modern-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    animation: fadeInUp 0.8s ease-out;
    overflow: hidden;
}

.profile-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.profile-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.3);
    background: linear-gradient(45deg, #ff9a9e, #fecfef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    position: relative;
    z-index: 2;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.profile-avatar i {
    font-size: 3rem;
    color: white;
}

.user-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 2;
}

.user-balance {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
    position: relative;
    z-index: 2;
}

.logout-btn {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.logout-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    color: white;
    text-decoration: none;
}

.info-section {
    padding: 40px 35px;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 25px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.info-item {
    margin-bottom: 25px;
}

.info-label {
    font-weight: 600;
    color: #5a6c7d;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.info-value {
    color: #2c3e50;
    font-size: 1.1rem;
}

.action-btn {
    background: linear-gradient(45deg, #a8edea, #fed6e3);
    border: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(168, 237, 234, 0.3);
    color: #2c3e50;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 15px 35px rgba(168, 237, 234, 0.4);
    color: #2c3e50;
    text-decoration: none;
}

.action-btn i {
    font-size: 1.5rem;
}

.admin-btn {
    background: linear-gradient(45deg, #ffd89b, #19547b);
}

.admin-btn:hover {
    box-shadow: 0 15px 35px rgba(255, 216, 155, 0.4);
}

.favorites-btn {
    background: linear-gradient(45deg, #ff9a9e, #fecfef);
}

.favorites-btn:hover {
    box-shadow: 0 15px 35px rgba(255, 154, 158, 0.4);
}

.cart-btn {
    background: linear-gradient(45deg, #a8e6cf, #dcedc1);
}

.cart-btn:hover {
    box-shadow: 0 15px 35px rgba(168, 230, 207, 0.4);
}
</style>

<div style="height: 42px;"></div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="modern-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="profile-section text-center text-white p-4 h-100 d-flex flex-column justify-content-center">
                            <div class="profile-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="user-name">{{ Auth::user()->name }}</h3>
                            @if(Auth::user()->tipo_usuario == 1)
                                <div class="badge bg-warning text-dark mb-3 fs-6"> </div>
                            @endif
                            <div class="user-balance">
                                <i class="fas fa-wallet me-2"></i>Saldo: {{ Auth::user()->saldo }} €
                            </div>
                            <a class="logout-btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="info-section">
                            <h4 class="section-title">Información</h4>
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                @if(Auth::user()->tipo_usuario == 1)
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <div class="info-label">Administrar productos</div>
                                        <a href="{{ route('administrar') }}" class="action-btn admin-btn">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <h4 class="section-title">Acciones</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <div class="info-label">Favoritos</div>
                                        <a href="{{ route('favoritos') }}" class="action-btn favorites-btn">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-item">
                                        <div class="info-label">Carrito de la compra</div>
                                        <a href="{{ route('mostrarProductoCarrito') }}" class="action-btn cart-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<div style="height: 50px;"></div>
@endsection