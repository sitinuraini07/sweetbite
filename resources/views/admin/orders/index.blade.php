@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-chocolate font-weight-bold">Manajemen Pesanan</h2>
        <div class="d-flex gap-3">
            <form action="/admin/orders" method="GET" class="mr-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-pill-left border-0 shadow-sm px-4" placeholder="Cari ID atau Nama..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-chocolate rounded-pill-right px-4 shadow-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <span class="badge badge-pill badge-chocolate px-3 py-2 d-flex align-items-center">{{ $orders->total() }} Total Pesanan</span>
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
                        <th class="border-0 px-4 py-3">ID</th>
                        <th class="border-0 py-3">Customer</th>
                        <th class="border-0 py-3">Total Harga</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    <tr>
                        <td class="px-4 py-4 align-middle font-weight-bold text-muted">#{{ $o->id }}</td>
                        <td class="py-4 align-middle">
                            <div class="font-weight-bold text-chocolate">{{ $o->user->name }}</div>
                            <div class="small text-muted">{{ $o->user->email }}</div>
                        </td>
                        <td class="py-4 align-middle font-weight-bold">
                            Rp {{ number_format($o->total_price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 align-middle text-center">
                            @php
                                $s = strtolower($o->status);
                                $statusClass = [
                                    'pending' => 'badge-soft-warning',
                                    'success' => 'badge-soft-success',
                                    'confirmed' => 'badge-soft-info',
                                    'shipping' => 'badge-soft-primary',
                                    'delivered' => 'badge-soft-success',
                                    'cancelled' => 'badge-soft-danger',
                                ][$s] ?? 'badge-soft-secondary';
                            @endphp
                            <span class="badge badge-pill {{ $statusClass }} px-3 py-2 font-weight-bold">
                                {{ strtoupper($o->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 align-middle text-right">
                            <div class="d-flex justify-content-end gap-1">
                            @if(in_array(strtolower($o->status), ['pending', 'success']))
                            <form action="/admin/orders/{{ $o->id }}/confirm" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-chocolate rounded-circle p-2 mx-1 shadow-sm" data-toggle="tooltip" data-placement="top" title="Accept Order">
                                    <i class="fas fa-check" style="width:16px;height:16px;"></i>
                                </button>
                            </form>
                            @endif

                            @if(strtolower($o->status) == 'confirmed')
                            <button class="btn btn-sm btn-outline-strawberry rounded-circle p-2 mx-1 shadow-sm" data-toggle="modal" data-target="#assignModal{{ $o->id }}" data-tooltip="tooltip" data-placement="top" title="Panggil Kurir">
                                <i class="fas fa-motorcycle" style="width:16px;height:16px;"></i>
                            </button>

                            <!-- Assign Modal -->
                            <div class="modal fade text-left" id="assignModal{{ $o->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content border-0 shadow rounded-lg">
                                        <form action="/admin/orders/{{ $o->id }}/assign" method="POST">
                                            @csrf
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title font-weight-bold">Tugaskan Kurir</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body pt-0">
                                                <div class="form-group">
                                                    <label class="small">Pilih Kurir Tersedia</label>
                                                    <select name="courier_id" class="form-control bg-light border-0 shadow-none" required>
                                                        @foreach($couriers as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-strawberry btn-block rounded-pill">Tugaskan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(in_array(strtolower($o->status), ['pending', 'confirmed']))
                            <button class="btn btn-sm btn-outline-info rounded-circle p-2 mx-1 shadow-sm" data-toggle="modal" data-target="#notifyModal{{ $o->id }}" data-tooltip="tooltip" data-placement="top" title="Beritahu Customer">
                                <i class="fas fa-bell" style="width:16px;height:16px;"></i>
                            </button>

                            <!-- Notify Modal -->
                            <div class="modal fade text-left" id="notifyModal{{ $o->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow rounded-lg">
                                        <form action="/admin/orders/{{ $o->id }}/notify" method="POST">
                                            @csrf
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title font-weight-bold">Kirim Pesan ke Pelanggan</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body pt-0">
                                                <div class="form-group">
                                                    <label class="small">Pesan (Contoh: Kurir sedang sibuk, mohon tunggu sebentar)</label>
                                                    <textarea name="note" class="form-control bg-light border-0 shadow-none" rows="3" required>Kurir kami sedang sibuk melayani pelanggan lain, mohon tunggu sebentar ya kak. Terima kasih atas kesabarannya! 🙏</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-info btn-block rounded-pill">Kirim Notifikasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .badge-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .btn-strawberry { background-color: #E91E63; color: white; }
    .btn-outline-strawberry { color: #E91E63; border-color: #E91E63; background: transparent; }
    .btn-outline-strawberry:hover { background-color: #E91E63; color: white; }
    .badge-soft-warning { background-color: #FFF8E1; color: #FFA000; }
    .badge-soft-info { background-color: #E1F5FE; color: #0288D1; }
    .badge-soft-primary { background-color: #E8EAF6; color: #3F51B5; }
    .badge-soft-success { background-color: #E8F5E9; color: #2E7D32; }
    .badge-soft-danger { background-color: #FFEBEE; color: #D32F2F; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection