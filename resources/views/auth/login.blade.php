@extends('index')

@section('contenido_principal')
<style>
/* Estilos coherentes con la página principal */
.auth-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 0;
}

.auth-section {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 20%, #667eea 100%);
    min-height: 90vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
}

.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    overflow: hidden;
    transition: all 0.3s ease;
}

.auth-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.2);
}

.auth-header {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 2rem;
    text-align: center;
    margin: -2rem -2rem 2rem -2rem;
}

.auth-title {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    opacity: 0.9;
    margin-bottom: 0;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating .form-control {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1rem 0.75rem;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.9);
}

.form-floating .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.form-floating label {
    color: #6c757d;
    font-weight: 500;
}

.btn-auth {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    width: 100%;
    text-transform: uppercase;
}

.btn-auth:hover {
    background: linear-gradient(45deg, #ee5a24, #ff6b6b);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    color: white;
}

.auth-links {
    margin-top: 2rem;
    text-align: center;
}

.auth-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: block;
    margin-bottom: 0.5rem;
}

.auth-links a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.form-check {
    margin: 1.5rem 0;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-check-label {
    color: #555;
    font-weight: 500;
}

.divider {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, #667eea, transparent);
    margin: 2rem 0;
}

.breadcrumb-custom {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
}

.breadcrumb-custom a {
    color: white;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-custom a:hover {
    color: #f8f9fa;
    text-decoration: underline;
}

.animate-fade-in {
    animation: fadeInUp 0.8s ease forwards;
}

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
</style>

<!-- Hero Section -->
<section class="auth-hero">
    <div class="container">
        <nav class="breadcrumb-custom">
            <a href="{{ route('principal') }}">Inicio</a>
            <span class="mx-2">/</span>
            <span>Iniciar Sesión</span>
        </nav>
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-sign-in-alt me-3"></i>ACCESO
            </h1>
            <p class="lead mb-0">Inicia sesión para acceder a tu cuenta</p>
        </div>
    </div>
</section>

<!-- Auth Section -->
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card auth-card animate-fade-in">
                    <div class="card-body p-4 p-sm-5">
                        <div class="auth-header">
                            <h2 class="auth-title">
                                <i class="fas fa-user-circle me-2"></i>Iniciar Sesión
                            </h2>
                            <p class="auth-subtitle">Accede a tu cuenta personal</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                       id="floatingInput" placeholder="email@ejemplo.com">
                                <label for="floatingInput"><i class="fas fa-envelope me-2"></i>Email</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password" 
                                       id="floatingPassword" placeholder="Contraseña">
                                <label for="floatingPassword"><i class="fas fa-lock me-2"></i>Contraseña</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    <i class="fas fa-check-circle me-2"></i>Recordarme
                                </label>
                            </div>

                            <button type="submit" class="btn btn-auth">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>

                            <hr class="divider">

                            <div class="auth-links">
                                <a href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-2"></i>¿Todavía no tienes cuenta? Regístrate
                                </a>
                                <a href="{{ route('password.request') }}">
                                    <i class="fas fa-key me-2"></i>¿Has olvidado la contraseña?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Animación al cargar
document.addEventListener('DOMContentLoaded', function() {
    const authCard = document.querySelector('.animate-fade-in');
    setTimeout(() => {
        authCard.style.opacity = '1';
        authCard.style.transform = 'translateY(0)';
    }, 200);
});
</script>

@endsection