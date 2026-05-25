@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="font-heading h2 mb-0">Admin Dashboard</h1>
            <p class="text-muted small mb-0">Ringkasan performa SweetBite hari ini.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/admin/products/create" class="btn btn-chocolate rounded-pill px-3 py-2 small shadow-sm">
                <i class="fas fa-plus mr-1"></i> Produk
            </a>
            <a href="/admin/categories/create" class="btn btn-outline-chocolate rounded-pill px-3 py-2 small shadow-sm">
                <i class="fas fa-folder mr-1"></i> Kategori
            </a>
        </div>
    </div>

    <!-- Quick Stats - Slim Version -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg p-3 bg-white border-left border-success" style="border-left-width: 4px !important;">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-success p-2 rounded-circle mr-3">
                        <i class="fas fa-coins text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 font-weight-bold">Pendapatan</p>
                        <h5 class="font-weight-bold mb-0">Rp {{ number_format($total_revenue, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg p-3 bg-white border-left border-primary" style="border-left-width: 4px !important;">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-primary p-2 rounded-circle mr-3">
                        <i class="fas fa-box text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 font-weight-bold">Produk</p>
                        <h5 class="font-weight-bold mb-0">{{ $products }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg p-3 bg-white border-left border-warning" style="border-left-width: 4px !important;">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-warning p-2 rounded-circle mr-3">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 font-weight-bold">Pending</p>
                        <h5 class="font-weight-bold mb-0">{{ $pending_orders }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg p-3 bg-white border-left border-info" style="border-left-width: 4px !important;">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-info p-2 rounded-circle mr-3">
                        <i class="fas fa-users text-info"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 font-weight-bold">Pelanggan</p>
                        <h5 class="font-weight-bold mb-0">{{ $total_users }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-lg p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="font-weight-bold mb-0">Statistik Pendapatan</h5>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-pill px-3 dropdown-toggle" type="button">7 Hari</button>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Mini Info Cards -->
        <div class="col-lg-4">
            <!-- Recent Transactions Mini -->
            <div class="card border-0 shadow-sm rounded-lg h-100 overflow-hidden">
                <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold mb-0">Transaksi Terakhir</h5>
                    <a href="/admin/orders" class="small text-strawberry font-weight-bold">Lihat Semua</a>
                </div>
                <div class="p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($transactions as $trx)
                        <li class="list-group-item border-0 p-3 hover-bg">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 mr-3 text-muted small">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-chocolate small">{{ $trx->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $trx->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-weight-bold text-chocolate small">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</div>
                                    @php
                                        $s = strtolower($trx->status);
                                        $statusClass = [
                                            'pending' => 'badge-soft-warning',
                                            'success' => 'badge-soft-success',
                                            'confirmed' => 'badge-soft-info',
                                            'shipping' => 'badge-soft-primary',
                                            'delivered' => 'badge-soft-success',
                                            'cancelled' => 'badge-soft-danger',
                                        ][$s] ?? 'badge-soft-secondary';
                                    @endphp
                                    <span class="badge badge-pill {{ $statusClass }}" style="font-size: 0.65rem;">
                                        {{ strtoupper($trx->status) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item border-0 p-4 text-center text-muted small">Belum ada transaksi</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const labels = @json($revenue_data->pluck('date'));
    const data = @json($revenue_data->pluck('total'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: data,
                borderColor: '#F28CAB',
                backgroundColor: 'rgba(242, 140, 171, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 4,
                pointRadius: 4,
                pointBackgroundColor: '#F28CAB',
                pointBorderColor: '#fff',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                    ticks: { 
                        font: { size: 10 }, 
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000) + 'M';
                            if (value >= 1000) return 'Rp ' + (value/1000) + 'k';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
</script>
@endsection

<style>
    .text-chocolate { color: #5D4037 !important; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .btn-outline-chocolate { color: #5D4037; border-color: #5D4037; }
    .btn-outline-chocolate:hover { background-color: #5D4037; color: white; }
    .text-strawberry { color: #F28CAB !important; }
    
    .bg-soft-success { background-color: #e8f8f5; }
    .bg-soft-primary { background-color: #eaf2f8; }
    .bg-soft-warning { background-color: #fef9e7; }
    .bg-soft-info { background-color: #e8f4fd; }
    
    .badge-soft-success { background-color: #e8f8f5; color: #27ae60; }
    .badge-soft-warning { background-color: #fef9e7; color: #f1c40f; }
    
    .hover-bg:hover { background-color: #fcf9f8; transition: 0.2s; }
    .gap-2 { gap: 0.5rem; }
</style>
@endsection