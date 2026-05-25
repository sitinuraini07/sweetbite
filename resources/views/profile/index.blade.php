@extends('layouts.app')

@section('content')
<div class="profile-header">
    <div class="container py-4">

        <a href="{{ route('profile.edit') }}" class="d-flex align-items-center mb-3 text-decoration-none">
            <div class="avatar-container position-relative">
                @if($user->profile_photo)
                    <img src="{{ asset($user->profile_photo) }}" class="rounded-circle border border-primary shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                @else
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 70px; height: 70px; font-size: 30px; font-weight: bold;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="ml-3">
                <h4 class="mb-0 font-weight-bold text-primary">{{ $user->name }}</h4>
                <div class="d-flex align-items-center mt-1">
                    <span class="badge bg-soft-strawberry text-strawberry px-2 py-1 mr-2" style="font-size: 0.7rem; border-radius: 10px; background: #FFF0F5;">Silver ></span>
                    <span class="small text-muted">26 Mengikuti | 0 Pengikut</span>
                </div>
            </div>
        </a>

    </div>
</div>

<div class="container mt-n3">
    <!-- Notice -->
    @if(!$user->phone_number)
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="card-body p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i data-lucide="user" class="text-primary mr-2" style="width: 20px;"></i>
                <span class="small text-muted">Silakan atur nomor handphone-mu. <a href="{{ route('profile.edit') }}" class="text-primary">Atur Sekarang</a></span>
            </div>
            <button type="button" class="close" style="font-size: 1.2rem;">&times;</button>
        </div>
    </div>
    @endif



    <!-- Additional Menu (Optional but clean) -->
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="list-group list-group-flush">
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center border-0">
                <div class="d-flex align-items-center">
                    <i data-lucide="user" class="text-primary mr-3" style="width: 24px;"></i>
                    <span>Detail Profil & Alamat</span>
                </div>
                <i data-lucide="chevron-right" class="text-muted" style="width: 16px;"></i>
            </a>
            <a href="/logout" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center border-0 border-top">
                <div class="d-flex align-items-center">
                    <i data-lucide="log-out" class="text-danger mr-3" style="width: 24px;"></i>
                    <span class="text-danger">Keluar</span>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    body { background-color: #FFF9F6; }
    main { padding-top: 0 !important; }
    
    .profile-header {
        background-color: #FFF9F6;
        padding-top: 100px;
        padding-bottom: 30px;
        position: relative;
    }
    
    .user-info-card {
        background: white;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(107, 62, 38, 0.05);
        margin-bottom: 20px;
        border: 1px solid rgba(107, 62, 38, 0.03);
    }
    
    .vip-banner {
        background: linear-gradient(90deg, #FDF0F3 0%, #FFF9F6 100%);
        border-radius: 16px;
        border: 1px solid #FFD1DC;
    }
    
    .vip-badge {
        background: #F28CAB;
        color: white;
        font-weight: bold;
        padding: 2px 10px;
        border-radius: 8px;
        font-size: 0.65rem;
    }
    
    .order-status-card {
        background: white;
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 8px 25px rgba(107, 62, 38, 0.03);
        margin-bottom: 20px;
    }
    
    .order-status-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #5D4037;
        font-size: 0.75rem;
        flex: 1;
        transition: all 0.3s;
    }
    
    .order-status-item:hover { text-decoration: none; color: #F28CAB; transform: translateY(-3px); }
    
    .order-status-item i, .order-status-item svg { 
        width: 28px; 
        height: 28px; 
        margin-bottom: 8px; 
        color: #F28CAB; 
        padding: 6px;
        background: #FFF0F5;
        border-radius: 10px;
    }
    
    .status-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #5D4037;
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 10px;
        border: 2px solid white;
        font-weight: bold;
    }
    
    .text-primary { color: #5D4037 !important; }
    .text-strawberry { color: #F28CAB !important; }
    
    .btn-primary { 
        background-color: #5D4037; 
        border-color: #5D4037; 
        color: white; 
        border-radius: 15px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary:hover { 
        background-color: #F28CAB; 
        border-color: #F28CAB; 
        color: white; 
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(242, 140, 171, 0.3);
    }
    
    .card { 
        border-radius: 20px !important; 
        border: none !important;
        box-shadow: 0 8px 25px rgba(107, 62, 38, 0.03) !important;
    }
    
    .menu-item {
        padding: 15px;
        transition: all 0.2s;
    }
    .menu-item:hover {
        background-color: #FFF9F6;
    }
    
    .shopee-logo-text {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
    }
</style>
@endsection

