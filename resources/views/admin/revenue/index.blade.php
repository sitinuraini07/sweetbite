@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="text-chocolate font-weight-bold mb-0">Laporan Pendapatan</h2>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body p-4">
            <form action="/admin/revenue" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-md-0 mb-3">
                        <label class="small font-weight-bold">Filter Berdasarkan</label>
                        <select name="filter" class="form-control bg-light border-0" onchange="this.form.submit()">
                            <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Harian</option>
                            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                </div>

                @if($filter == 'day')
                <div class="col-md-3">
                    <div class="form-group mb-md-0 mb-3">
                        <label class="small font-weight-bold">Pilih Tanggal</label>
                        <input type="date" name="date" class="form-control bg-light border-0" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                </div>
                @elseif($filter == 'month')
                <div class="col-md-3">
                    <div class="form-group mb-md-0 mb-3">
                        <label class="small font-weight-bold">Pilih Bulan</label>
                        <select name="month" class="form-control bg-light border-0" onchange="this.form.submit()">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-md-0 mb-3">
                        <label class="small font-weight-bold">Pilih Tahun</label>
                        <select name="year" class="form-control bg-light border-0" onchange="this.form.submit()">
                            @foreach(range(date('Y'), date('Y')-5) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @elseif($filter == 'year')
                <div class="col-md-3">
                    <div class="form-group mb-md-0 mb-3">
                        <label class="small font-weight-bold">Pilih Tahun</label>
                        <select name="year" class="form-control bg-light border-0" onchange="this.form.submit()">
                            @foreach(range(date('Y'), date('Y')-5) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                <div class="col-md-2">
                    <button type="submit" class="btn btn-chocolate btn-block rounded-pill">Cari</button>
                </div>
            </form>

            <!-- Download Buttons Row (below Cari) -->
            <div class="d-flex mt-3 pt-3" style="border-top: 1px solid rgba(107, 62, 38, 0.08); gap: 0.5rem;">
                <a href="{{ url('/admin/revenue/excel?filter='.$filter.'&date='.$date.'&month='.$month.'&year='.$year) }}" class="btn btn-download-excel rounded-pill px-4 shadow-sm" data-toggle="tooltip" data-placement="top" title="Download laporan dalam format Excel (.xlsx)">
                    <i class="fas fa-file-excel mr-2"></i> Excel
                </a>
                <a href="{{ url('/admin/revenue/pdf?filter='.$filter.'&date='.$date.'&month='.$month.'&year='.$year) }}" class="btn btn-download-pdf rounded-pill px-4 shadow-sm" data-toggle="tooltip" data-placement="top" title="Download laporan dalam format PDF (.pdf)">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="card border-0 shadow-sm rounded-lg mb-4 bg-chocolate text-white">
        <div class="card-body p-4 text-center">
            <h5 class="mb-2 opacity-80">Total Pendapatan Bersih</h5>
            <h1 class="font-weight-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h1>
            <p class="mb-0 small opacity-80">Data berdasarkan status pesanan "DELIVERED"</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="text-chocolate">
                        <th class="border-0 px-4 py-3">ID Pesanan</th>
                        <th class="border-0 py-3">Tanggal</th>
                        <th class="border-0 py-3">Customer</th>
                        <th class="border-0 py-3 text-right px-4">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td class="px-4 py-4 align-middle font-weight-bold">#SB-{{ $t->id }}</td>
                        <td class="py-4 align-middle small text-muted">{{ $t->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-4 align-middle font-weight-bold text-chocolate">{{ $t->user->name }}</td>
                        <td class="py-4 align-middle text-right px-4 font-weight-bold">
                            Rp {{ number_format($t->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Tidak ada data untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .bg-chocolate { background-color: #5D4037; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }

    /* Download button styles - rectangle rounded-pill like Cari */
    .btn-download-excel {
        background-color: #217346;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .btn-download-excel:hover {
        background-color: #1a5c38;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 115, 70, 0.3) !important;
    }
    .btn-download-pdf {
        background-color: #C62828;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .btn-download-pdf:hover {
        background-color: #a11f1f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(198, 40, 40, 0.3) !important;
    }
</style>
@endsection
