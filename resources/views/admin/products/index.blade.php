@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-chocolate font-weight-bold">Manajemen Produk</h2>
        <div class="d-flex gap-3">
            <form action="/admin/products" method="GET" class="mr-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-pill-left border-0 shadow-sm px-4" placeholder="Cari nama produk..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-chocolate rounded-pill-right px-4 shadow-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="/admin/products/create" class="btn btn-chocolate rounded-pill px-4 shadow-sm flex-shrink-0">
                <i class="fas fa-plus mr-1"></i> <span class="d-none d-sm-inline">Tambah Produk</span><span class="d-inline d-sm-none">Tambah</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="text-chocolate">
                        <th class="border-0 px-4 py-3">Produk</th>
                        <th class="border-0 py-3">Kategori</th>
                        <th class="border-0 py-3">Harga</th>
                        <th class="border-0 py-3">Stock</th>
                        <th class="border-0 px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td class="px-4 py-4 align-middle">
                            <div class="d-flex align-items-center">
                                @if($p->image)
                                    <img src="{{ asset('storage/'.$p->image) }}" class="rounded shadow-sm mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded mr-3 d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="font-weight-bold text-chocolate">{{ $p->name }}</div>
                            </div>
                        </td>
                        <td class="py-4 align-middle">
                            <span class="badge badge-pill badge-light px-3 py-2">{{ $p->category->name ?? 'No Category' }}</span>
                        </td>
                        <td class="py-4 align-middle font-weight-bold">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 align-middle">
                            <span class="badge badge-pill {{ $p->stock > 10 ? 'badge-soft-success' : 'badge-soft-warning' }} px-3 py-2">
                                {{ $p->stock }} Tersedia
                            </span>
                        </td>
                        <td class="px-4 py-4 align-middle text-right">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="/admin/products/{{ $p->id }}/edit" class="btn btn-sm btn-light rounded-circle p-2 mx-1 shadow-sm" data-toggle="tooltip" data-placement="top" title="Edit Produk">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <form action="/admin/products/{{ $p->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light rounded-circle p-2 mx-1 shadow-sm" data-toggle="tooltip" data-placement="top" title="Hapus Produk" onclick="return confirm('Hapus produk ini?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .badge-soft-success { background-color: #E8F5E9; color: #2E7D32; }
    .badge-soft-warning { background-color: #FFF8E1; color: #FFA000; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection