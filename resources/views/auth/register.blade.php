@extends('layouts.app')

@section('styles')
<style>
    .register-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
        background-size: cover;
        position: relative;
        padding: 4rem 2rem;
        margin-top: -8rem;
    }

    .register-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(45, 27, 24, 0.8), rgba(217, 125, 153, 0.4));
        backdrop-filter: blur(5px);
        z-index: 1;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 2.5rem;
        padding: 4rem;
        width: 100%;
        max-width: 550px;
        position: relative;
        z-index: 2;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .register-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .register-header h1 {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
        font-weight: 900;
    }

    .register-header p {
        color: var(--text-muted);
        font-size: 1.1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group.full {
        grid-column: 1 / -1;
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
        padding: 1.1rem 1.5rem;
        border-radius: 1.2rem;
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

    .btn-register {
        background: var(--secondary);
        color: white;
        width: 100%;
        padding: 1.2rem;
        border-radius: 1.2rem;
        border: none;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(242, 140, 171, 0.2);
    }

    .btn-register:hover {
        background: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(242, 140, 171, 0.3);
    }

    .register-footer {
        text-align: center;
        margin-top: 2.5rem;
        font-size: 1rem;
        color: var(--text-muted);
    }

    .register-footer a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }

    .register-footer a:hover {
        color: var(--secondary);
        text-decoration: underline;
    }

    .error-msg {
        color: var(--accent);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .register-card {
            padding: 3rem 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="register-section">
    <div class="register-card animate-fade">
        <div class="register-header">
            <h1>Join Us</h1>
            <p>Mulai perjalanan manis Anda bersama SweetBite.</p>
        </div>

        <form action="/register" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control-custom" placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
                </div>

                <div class="form-group full">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control-custom" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-msg"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control-custom" placeholder="••••••••" required>
                </div>
            </div>

            <div class="form-group d-flex justify-content-center">
                <div class="captcha-wrapper" style="transform: scale(0.9);">
                    {!! htmlFormSnippet() !!}
                    {!! htmlScriptTagJsApi() !!}
                    @error('g-recaptcha-response')
                        <span class="error-msg text-center mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-register">
                Create Account <i class="fas fa-user-plus ml-2"></i>
            </button>
            
            <div class="register-footer">
                Sudah punya akun? <a href="/login">Masuk di sini</a>
            </div>
        </form>
    </div>
</div>
@endsection
