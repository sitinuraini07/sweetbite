@extends('layouts.app')

@section('styles')
<style>
    .admin-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(107, 62, 38, 0.05);
        border: 1px solid rgba(107, 62, 38, 0.05);
    }
    .text-chocolate { color: #5D4037; }
    .btn-chocolate { background-color: #5D4037; color: white; border-radius: 12px; transition: all 0.3s; }
    .btn-chocolate:hover { background-color: #4E342E; transform: translateY(-2px); color: white; }
    .table-custom th { border-top: none; color: #8D7773; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
    .courier-avatar { width: 45px; height: 45px; border-radius: 12px; background: #FFF9F6; display: flex; align-items: center; justify-content: center; color: #F28CAB; font-weight: bold; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-chocolate font-weight-bold mb-1">Manajemen Kurir</h2>
            <p class="text-muted">Kelola data kurir internal toko Anda di sini.</p>
        </div>
        <a href="/admin/couriers/create" class="btn btn-chocolate px-4 py-2 font-weight-bold shadow-sm">
            <i class="fas fa-plus mr-2"></i> Tambah Kurir
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th>Kurir</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($couriers as $courier)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="courier-avatar mr-3">
                                    {{ strtoupper(substr($courier->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-weight-bold text-chocolate">{{ $courier->name }}</div>
                                    <div class="small text-muted">ID: #C{{ $courier->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small"><i class="fas fa-envelope text-muted mr-1"></i> {{ $courier->email }}</div>
                            <div class="small mt-1"><i class="fas fa-phone text-muted mr-1"></i> {{ $courier->phone_number ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="small text-muted" style="max-width: 250px;">
                                {{ $courier->address ?? 'Alamat belum diatur' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/admin/couriers/{{ $courier->id }}/edit" class="btn btn-sm btn-light rounded-circle p-2 mx-1 shadow-sm" data-toggle="tooltip" data-placement="top" title="Edit Kurir">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <form action="/admin/couriers/{{ $courier->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kurir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle p-2 mx-1 shadow-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kurir">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <img src="https://illustrations.popsy.co/amber/delivery.svg" style="width: 150px;" class="mb-3">
                            <h5 class="text-muted">Belum ada data kurir.</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
