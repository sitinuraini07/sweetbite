@extends('layouts.app')

@section('styles')
<style>
    :root {
        --sweet-brown: #3E2723;
        --sweet-pink: #F28CAB;
        --ui-bg: #F8F9FA;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.04);
        --border-color: #EDEFF2;
    }

    body {
        background-color: var(--ui-bg);
        font-family: 'Inter', sans-serif;
    }

    .orders-master-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 8rem 2rem 5rem;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 3.5rem;
    }

    .header-section h1 {
        font-weight: 800;
        color: var(--sweet-brown);
        font-size: 2.2rem;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .header-section p {
        color: #888;
        margin: 5px 0 0;
    }

    /* Professional Navigation */
    .nav-filters-wrapper {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 3rem;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: none;
    }

    .nav-filters-wrapper::-webkit-scrollbar {
        display: none;
    }

    .filter-btn-modern {
        padding: 10px 24px;
        background: white;
        color: #666;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.3s;
        border: 1px solid var(--border-color);
        white-space: nowrap;
    }

    .filter-btn-modern:hover {
        border-color: var(--sweet-pink);
        color: var(--sweet-pink);
        transform: translateY(-2px);
    }

    .filter-btn-modern.active {
        background: var(--sweet-brown);
        color: white;
        border-color: var(--sweet-brown);
        box-shadow: 0 8px 20px rgba(62, 39, 35, 0.2);
    }

    /* Professional Grid Layout */
    .orders-horizontal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2.5rem;
    }

    .pro-order-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .pro-order-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.06);
        border-color: rgba(242, 140, 171, 0.3);
    }

    .card-pro-head {
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
        border-bottom: 1px solid var(--border-color);
    }

    .order-id-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #AAA;
        letter-spacing: 1px;
    }

    .pro-status-badge {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .badge-pro-pending { background: #FFF8E1; color: #F57F17; }
    .badge-pro-shipping { background: #E3F2FD; color: #1976D2; }
    .badge-pro-success { background: #E8F5E9; color: #388E3C; }

    .card-pro-body {
        padding: 2rem;
        flex: 1;
    }

    .pro-product-row {
        display: flex;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }

    .pro-product-row:last-child {
        margin-bottom: 0;
    }

    .pro-img {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .pro-info-text h6 {
        margin: 0 0 4px;
        font-weight: 700;
        color: var(--sweet-brown);
        font-size: 0.95rem;
    }

    .pro-info-text p {
        margin: 0;
        font-size: 0.75rem;
        color: #999;
    }

    .pro-qty-pill {
        display: inline-block;
        margin-top: 6px;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--sweet-pink);
    }

    .card-pro-foot {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
    }

    .pro-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .pro-total-row span {
        font-size: 0.85rem;
        color: #777;
        font-weight: 600;
    }

    .pro-total-row strong {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--sweet-brown);
    }

    .pro-actions-flex {
        display: flex;
        gap: 10px;
    }

    .btn-pro-action {
        flex: 1;
        padding: 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        text-align: center;
        transition: all 0.3s;
        border: 1px solid transparent;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-pro-primary {
        background: var(--sweet-pink);
        color: white;
    }

    .btn-pro-primary:hover {
        background: #e57e9e;
        color: white;
    }

    .btn-pro-outline {
        background: white;
        color: #555;
        border-color: var(--border-color);
    }

    .btn-pro-outline:hover {
        border-color: var(--sweet-pink);
        color: var(--sweet-pink);
    }

    @media (max-width: 768px) {
        .orders-horizontal-grid { grid-template-columns: 1fr; }
        .orders-master-container { padding: 7rem 1.5rem 5rem; }
    }
</style>
@endsection

@section('content')
<div class="orders-master-container">
    <div class="header-section">
        <div>
            <h1>Pesanan Saya</h1>
            <p>Riwayat dan status belanja Anda di SweetBite.</p>
        </div>
        <div class="d-none d-md-block">
            <a href="/products" class="btn-pro-action btn-pro-outline px-4">Lanjut Belanja</a>
        </div>
    </div>

    <!-- Professional Navigation -->
    <div class="nav-filters-wrapper">
        <a href="{{ route('profile.orders', ['status' => 'all']) }}" class="filter-btn-modern {{ $status == 'all' ? 'active' : '' }}">Semua Pesanan</a>
        <a href="{{ route('profile.orders', ['status' => 'pending']) }}" class="filter-btn-modern {{ $status == 'pending' ? 'active' : '' }}">Belum Bayar</a>
        <a href="{{ route('profile.orders', ['status' => 'confirmed']) }}" class="filter-btn-modern {{ $status == 'confirmed' ? 'active' : '' }}">Diproses</a>
        <a href="{{ route('profile.orders', ['status' => 'shipping']) }}" class="filter-btn-modern {{ $status == 'shipping' ? 'active' : '' }}">Dalam Pengiriman</a>
        <a href="{{ route('profile.orders', ['status' => 'delivered']) }}" class="filter-btn-modern {{ $status == 'delivered' ? 'active' : '' }}">Tiba di Tujuan</a>
        <a href="{{ route('profile.orders', ['status' => 'completed']) }}" class="filter-btn-modern {{ $status == 'completed' ? 'active' : '' }}">Selesai</a>
    </div>

    <!-- Grid Layout -->
    <div class="orders-horizontal-grid">
        @forelse($transactions as $trx)
        @php
            $statusMap = [
                'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-pro-pending'],
                'success' => ['label' => 'Pembayaran Berhasil', 'class' => 'badge-pro-success'],
                'confirmed' => ['label' => 'Diproses', 'class' => 'badge-pro-pending'],
                'shipping' => ['label' => 'Dalam Pengiriman', 'class' => 'badge-pro-shipping'],
                'delivered' => ['label' => 'Sudah Sampai', 'class' => 'badge-pro-success'],
                'completed' => ['label' => 'Selesai', 'class' => 'badge-pro-success'],
                'refunded' => ['label' => 'Refund', 'class' => 'badge-pro-pending'],
                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'badge-pro-pending'],
            ];
            $curStatus = $statusMap[strtolower($trx->status)] ?? ['label' => strtoupper($trx->status), 'class' => ''];
        @endphp

        <div class="pro-order-card animate-fade">
            <div class="card-pro-head">
                <div class="order-id-label">#SB-{{ $trx->id }}</div>
                <div class="pro-status-badge {{ $curStatus['class'] }}">
                    {{ $curStatus['label'] }}
                </div>
            </div>

            <div class="card-pro-body">
                @foreach($trx->details as $detail)
                <div class="pro-product-row">
                    <img src="{{ asset('storage/' . $detail->product->image) }}" class="pro-img">
                    <div class="pro-info-text">
                        <h6>{{ $detail->product->name }}</h6>
                        <p>Pilihan Gourmet SweetBite</p>
                        <div class="pro-qty-pill">{{ $detail->quantity }} Barang</div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="font-weight-bold" style="color: var(--sweet-brown); font-size: 0.9rem;">
                            Rp {{ number_format($detail->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                @endforeach

                @if(in_array($trx->status, ['confirmed', 'shipping', 'delivered', 'completed', 'pending']))
                <div style="background: #FFF0F5; border-radius: 12px; padding: 10px 15px; margin-top: 1.5rem; display: flex; align-items: center; gap: 10px; border: 1px solid rgba(242, 140, 171, 0.2);">
                    <i class="fas fa-shipping-fast" style="color: var(--sweet-pink); font-size: 1rem;"></i>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--sweet-brown);">
                        {{ $trx->estimated_arrival }}
                    </span>
                </div>
                @endif
            </div>

            <div class="card-pro-foot">
                <div class="pro-total-row">
                    <span>Total Transaksi</span>
                    <strong>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</strong>
                </div>

                <div class="pro-actions-flex">
                    @if($trx->status == 'pending')
                        <a href="/pay/{{ $trx->id }}" class="btn-pro-action btn-pro-primary">Bayar</a>
                    @elseif($trx->status == 'shipping')
                        <a href="{{ route('profile.track', $trx->id) }}" class="btn-pro-action btn-pro-primary">Lacak</a>
                    @elseif($trx->status == 'delivered')
                        <a href="{{ route('profile.track', $trx->id) }}" class="btn-pro-action btn-pro-outline">Lacak</a>
                        <form action="{{ route('profile.confirm', $trx->id) }}" method="POST" style="flex: 1">
                            @csrf
                            <button type="submit" class="btn-pro-action btn-pro-primary w-100">Selesai</button>
                        </form>
                    @elseif($trx->status == 'completed')
                        <a href="/products" class="btn-pro-action btn-pro-outline">Ulas</a>
                        <a href="/products" class="btn-pro-action btn-pro-primary">Beli Lagi</a>
                    @else
                        <a href="/products" class="btn-pro-action btn-pro-outline w-100">Lihat Produk</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 w-100">
            <img src="https://illustrations.popsy.co/amber/order-confirmed.svg" style="width: 250px;" class="mb-4">
            <h4 class="font-weight-bold" style="color: var(--sweet-brown)">Belum Ada Riwayat Pesanan</h4>
            <a href="/products" class="btn-pro-action btn-pro-primary mt-4 px-5 mx-auto" style="width: fit-content">Mulai Belanja</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
