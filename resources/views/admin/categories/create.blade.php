@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-chocolate font-weight-bold">Kategori Baru</h2>
                <a href="/admin/categories" class="btn btn-outline-chocolate rounded-pill px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-lg p-5 text-center">
                <div class="mb-4">
                    <i class="fas fa-folder-plus text-strawberry" style="font-size: 3rem;"></i>
                </div>
                <h4 class="text-chocolate mb-4">Nama Kategori</h4>
                <form action="/admin/categories" method="POST">
                    @csrf
                    
                    <div class="form-group mb-5">
                        <input type="text" name="name" class="form-control rounded-pill border-0 shadow-sm bg-light px-4 text-center" style="height: 60px; font-size: 1.2rem;" placeholder="Contoh: Cakes, Cookies, Drinks" required>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-block btn-pill py-3 font-weight-bold shadow-lg">
                        Simpan Kategori 📂
                    </button>
                </form>
            </div>

            <div class="mt-4 p-4 rounded-lg bg-white shadow-sm border-left border-strawberry" style="border-left-width: 5px !important;">
                <p class="mb-0 text-muted small">
                    <i class="fas fa-info-circle mr-2"></i> Kategori akan muncul sebagai filter di halaman menu pelanggan. Gunakan nama yang singkat dan deskriptif.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .text-strawberry { color: #E91E63; }
    .btn-outline-chocolate { color: #5D4037; border-color: #5D4037; }
    .btn-outline-chocolate:hover { background-color: #5D4037; color: white; }
    .border-strawberry { border-color: #E91E63 !important; }
</style>
@endsection