@extends('layouts.app')

@section('styles')
<style>
    .login-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
        background-size: cover;
        position: relative;
        padding: 2rem;
        margin-top: -8rem; /* Offset main padding */
    }

    .login-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(107, 62, 38, 0.8), rgba(242, 140, 171, 0.4));
        backdrop-filter: blur(5px);
        z-index: 1;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 2rem;
        padding: 4rem 3rem;
        width: 100%;
        max-width: 500px;
        position: relative;
        z-index: 2;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .login-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .login-header h1 {
        font-size: 2.8rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }

    .login-header p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.8rem;
        display: block;
        font-size: 0.9rem;
    }

    .form-control-custom {
        width: 100%;
        padding: 1.2rem 1.5rem;
        border-radius: 1rem;
        border: 2px solid rgba(107, 62, 38, 0.1);
        background: white;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .form-control-custom:focus {
        border-color: var(--secondary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(242, 140, 171, 0.15);
    }

    .btn-login {
        background: var(--primary);
        color: white;
        width: 100%;
        padding: 1.2rem;
        border-radius: 1rem;
        border: none;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(107, 62, 38, 0.2);
    }

    .btn-login:hover {
        background: var(--dark-choco);
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(107, 62, 38, 0.3);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(0,0,0,0.1);
    }

    .divider span {
        padding: 0 1rem;
    }

    .btn-google {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        width: 100%;
        padding: 1.1rem;
        border-radius: 1rem;
        border: 2px solid rgba(0,0,0,0.05);
        background: white;
        color: var(--primary);
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.3s;
    }

    .btn-google:hover {
        background: #fafafa;
        border-color: rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .login-footer {
        text-align: center;
        margin-top: 2.5rem;
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .login-footer a {
        color: var(--secondary);
        font-weight: 700;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    .error-msg {
        color: var(--accent);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }

    /* Recaptcha Scaling */
    .g-recaptcha {
        transform: scale(0.9);
        transform-origin: 0 0;
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 3rem 2rem;
        }
        .login-header h1 {
            font-size: 2.2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="login-section">
    <div class="login-card animate-fade">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Masuk untuk melanjutkan petualangan rasa Anda.</p>
        </div>

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control-custom" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-msg"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group d-flex justify-content-center">
                <div class="captcha-wrapper">
                    {!! htmlFormSnippet() !!}
                    {!! htmlScriptTagJsApi() !!}
                    @error('g-recaptcha-response')
                        <span class="error-msg text-center mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-login">
                Sign In <i class="fas fa-arrow-right ml-2"></i>
            </button>
            
            <div class="divider">
                <span>OR</span>
            </div>

            <a href="{{ route('google.login') }}" class="btn-google">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width: 20px;">
                Continue with Google
            </a>

            <div class="login-footer">
                Belum punya akun? <a href="/register">Daftar Sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
