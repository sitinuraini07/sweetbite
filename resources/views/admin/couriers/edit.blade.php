@extends('layouts.app')

@section('styles')
<style>
    .admin-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(107, 62, 38, 0.05);
        border: 1px solid rgba(107, 62, 38, 0.05);
    }
    .text-chocolate { color: #5D4037; }
    .form-label { font-weight: 600; color: #5D4037; margin-bottom: 0.5rem; }
    .form-control-custom { border-radius: 12px; padding: 0.8rem 1.2rem; border: 1px solid #eee; background: #fafafa; transition: all 0.3s; }
    .form-control-custom:focus { border-color: #F28CAB; box-shadow: 0 0 0 4px rgba(242, 140, 171, 0.1); background: white; outline: none; }
    .btn-chocolate { background-color: #5D4037; color: white; border-radius: 12px; transition: all 0.3s; border: none; }
    .btn-chocolate:hover { background-color: #4E342E; transform: translateY(-2px); color: white; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="/admin/couriers" class="text-muted text-decoration-none small">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                </a>
                <h2 class="text-chocolate font-weight-bold mt-2">Edit Data Kurir</h2>
                <p class="text-muted">Perbarui informasi profil kurir <strong>{{ $courier->name }}</strong>.</p>
            </div>

            <div class="admin-card">
                <form action="/admin/couriers/{{ $courier->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control-custom w-100" value="{{ $courier->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Aktif</label>
                            <input type="email" name="email" class="form-control-custom w-100" value="{{ $courier->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ganti Password (Opsional)</label>
                            <input type="password" name="password" class="form-control-custom w-100" placeholder="Kosongkan jika tidak diganti">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone_number" class="form-control-custom w-100" value="{{ $courier->phone_number }}">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control-custom w-100" rows="3">{{ $courier->address }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-chocolate px-5 py-3 font-weight-bold shadow-sm w-100">
                        <i class="fas fa-sync-alt mr-2"></i> Perbarui Data Kurir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
