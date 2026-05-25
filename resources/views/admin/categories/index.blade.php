@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-chocolate font-weight-bold">Manajemen Kategori</h2>
        <div class="d-flex gap-3">
            <form action="/admin/categories" method="GET" class="mr-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-pill-left border-0 shadow-sm px-4" placeholder="Cari kategori..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-chocolate rounded-pill-right px-4 shadow-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="/admin/categories/create" class="btn btn-chocolate rounded-pill px-4 shadow-sm flex-shrink-0">
                <i class="fas fa-plus mr-1"></i> <span class="d-none d-sm-inline">Tambah Kategori</span><span class="d-inline d-sm-none">Tambah</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr class="text-chocolate">
                                <th class="border-0 px-4 py-3">Nama Kategori</th>
                                <th class="border-0 py-3 text-center">Jumlah Produk</th>
                                <th class="border-0 px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $c)
                            <tr>
                                <td class="px-4 py-4 align-middle font-weight-bold text-chocolate">
                                    {{ $c->name }}
                                </td>
                                <td class="py-4 align-middle text-center">
                                    <span class="badge badge-pill badge-light px-3 py-2">{{ $c->products->count() ?? 0 }} Produk</span>
                                </td>
                                <td class="px-4 py-4 align-middle text-right">
                                    <form action="/admin/categories/{{ $c->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-light rounded-circle p-2 shadow-sm" data-toggle="tooltip" data-placement="top" title="Hapus Kategori" onclick="return confirm('Hapus kategori ini?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-lg p-4" style="background: var(--bg-soft);">
                <h5 class="text-chocolate font-weight-bold mb-3">Informasi</h5>
                <p class="text-muted small">Kategori membantu pelanggan menemukan produk favorit mereka dengan lebih mudah. Pastikan nama kategori jelas dan menarik.</p>
                <div class="d-flex align-items-center mt-3 p-3 rounded bg-white shadow-sm">
                    <i class="fas fa-tags text-strawberry mr-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <div class="small text-muted">Total Kategori</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $categories->total() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .text-strawberry { color: #E91E63; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection