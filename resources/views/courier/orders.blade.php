@extends('layouts.app')

@section('styles')
<style>
    :root {
        --gojek-green: #00AA13;
        --gojek-dark: #222222;
        --sweet-brown: #3E2723;
        --border-color: #EDEFF2;
        --bg-soft: #F8F9FA;
    }

    body {
        background-color: var(--bg-soft);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .courier-master-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 8rem 2rem 5rem;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4rem;
    }

    .dashboard-header h1 {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--sweet-brown);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .stats-summary {
        display: flex;
        gap: 1.5rem;
    }

    .stat-pill {
        background: white;
        padding: 10px 20px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #555;
    }

    .stat-pill i { color: var(--gojek-green); }

    /* Orders Grid */
    .courier-orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2.5rem;
    }

    .task-card-pro {
        background: white;
        border-radius: 28px;
        border: 1px solid var(--border-color);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .task-card-pro:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.06);
    }

    .task-head {
        padding: 1.8rem 2rem;
        background: #FAFAFA;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-num {
        font-size: 0.75rem;
        font-weight: 800;
        color: #BBB;
        letter-spacing: 1px;
    }

    .status-badge-mini {
        padding: 6px 14px;
        border-radius: 8px;
        background: #E8F5E9;
        color: var(--gojek-green);
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .task-body {
        padding: 2rem;
        flex: 1;
    }

    .customer-profile-box {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .customer-avatar {
        width: 54px;
        height: 54px;
        background: #E8F5E9;
        color: var(--gojek-green);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 800;
    }

    .customer-info-text h5 {
        margin: 0;
        font-weight: 800;
        color: var(--sweet-brown);
        font-size: 1.1rem;
    }

    .customer-info-text p {
        margin: 0;
        font-size: 0.8rem;
        color: #888;
    }

    .address-box-pro {
        background: #F9FAFB;
        padding: 1.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        border: 1px solid #F1F1F1;
    }

    .address-box-pro .label {
        font-size: 0.7rem;
        font-weight: 800;
        color: #AAA;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
    }

    .address-box-pro .content {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--sweet-brown);
        line-height: 1.5;
    }

    .task-foot {
        padding: 1.8rem 2rem;
        border-top: 1px solid var(--border-color);
        background: white;
    }

    .action-group-pro {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .btn-pro-courier {
        padding: 1.1rem;
        border-radius: 18px;
        font-weight: 800;
        font-size: 0.85rem;
        text-align: center;
        transition: all 0.3s;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none !important;
    }

    .btn-maps-pro {
        background: white;
        color: #555;
        border: 1px solid var(--border-color);
    }

    .btn-maps-pro:hover {
        background: #F5F5F5;
    }

    .btn-done-pro {
        background: var(--gojek-green);
        color: white;
        box-shadow: 0 10px 25px rgba(0, 170, 19, 0.2);
    }

    .btn-done-pro:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0, 170, 19, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .courier-orders-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="courier-master-wrapper">
    <div class="dashboard-header">
        <div>
            <h1>Dashboard Kurir</h1>
            <p class="text-muted">Pantau dan selesaikan pengantaran Anda hari ini.</p>
        </div>
        <div class="stats-summary d-none d-md-flex">
            <button type="button" class="stat-pill border-0" data-toggle="modal" data-target="#historyTodayModal" style="cursor: pointer;">
                <i class="fas fa-check-double text-success"></i>
                <span>{{ $deliveredToday }} Selesai Hari Ini</span>
            </button>
            <div class="stat-pill">
                <i class="fas fa-motorcycle"></i>
                <span>{{ count($orders) }} Tugas Aktif</span>
            </div>
        </div>
    </div>

    <div class="courier-orders-grid">
        @forelse($orders as $o)
        <div class="task-card-pro animate-fade">
            <div class="task-head">
                <div class="order-num">#SB-{{ $o->id }}</div>
                <div class="status-badge-mini">Sedang Dikirim</div>
            </div>

            <div class="task-body">
                <div class="customer-profile-box">
                    <div class="customer-avatar">
                        {{ substr($o->user->name, 0, 1) }}
                    </div>
                    <div class="customer-info-text">
                        <p>Penerima</p>
                        <h5>{{ $o->user->name }}</h5>
                    </div>
                    <a href="tel:{{ $o->address->phone_number }}" class="ml-auto btn btn-light rounded-circle p-3 shadow-sm">
                        <i class="fas fa-phone-alt text-success"></i>
                    </a>
                </div>

                <div class="address-box-pro">
                    <span class="label">Alamat Pengantaran</span>
                    <div class="content">{{ $o->address->alamat_lengkap }}</div>
                    <div class="mt-2 text-muted small"><i class="fas fa-map-marker-alt mr-1"></i> {{ $o->address->kota }}, {{ $o->address->postal_code }}</div>
                </div>

                <div class="small text-muted mb-2">Item Pesanan:</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($o->details as $d)
                        <span class="badge badge-light border rounded-pill py-2 px-3 font-weight-bold" style="font-size: 0.7rem;">
                            {{ $d->product->name }} (x{{ $d->quantity }})
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="task-foot">
                <div class="action-group-pro">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $o->address->latitude }},{{ $o->address->longitude }}&travelmode=motorcycle" 
                       target="_blank" class="btn-pro-courier btn-maps-pro">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Google_Maps_icon_%282015-2020%29.svg" style="width: 18px;">
                        Peta
                    </a>
                    
                    <button type="button" class="btn-pro-courier btn-done-pro" data-toggle="modal" data-target="#proofModal{{ $o->id }}">
                        <i class="fas fa-check-circle"></i>
                        Selesai
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Proof (Same logic as before, just UI check) -->
        <div class="modal fade" id="proofModal{{ $o->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 35px; border: none; overflow: hidden;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <h5 class="modal-title font-weight-bold" style="color: var(--sweet-brown)">Bukti Pengantaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/courier/orders/{{ $o->id }}/done" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <label for="proofInput{{ $o->id }}" style="cursor: pointer;" class="w-100">
                                    <div id="uploadPlaceholder{{ $o->id }}" class="p-5 border rounded-lg d-flex flex-column align-items-center justify-content-center" style="background: #F8F9FA; border: 2px dashed #DDD; border-radius: 25px !important;">
                                        <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                                        <span class="font-weight-bold text-muted">Ambil Foto Paket</span>
                                    </div>
                                    <div id="preview-container-{{ $o->id }}" class="d-none">
                                        <img id="preview-{{ $o->id }}" src="#" alt="Preview" style="max-width: 100%; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 4px solid white;">
                                    </div>
                                </label>
                                <input type="file" name="proof_image" class="d-none" id="proofInput{{ $o->id }}" onchange="previewImage(this, {{ $o->id }})" required accept="image/*" capture="camera">
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="submit" class="btn-pro-courier btn-done-pro w-100 py-3">
                                Konfirmasi & Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 w-100">
            <img src="https://illustrations.popsy.co/amber/relaxing-at-home.svg" style="width: 250px;" class="mb-4">
            <h4 class="font-weight-bold" style="color: var(--sweet-brown)">Semua Tugas Selesai!</h4>
            <p class="text-muted">Saatnya istirahat sejenak.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal History Today -->
<div class="modal fade" id="historyTodayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 35px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title font-weight-bold" style="color: var(--sweet-brown)">Pengantaran Selesai Hari Ini</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="text-muted small font-weight-bold" style="border-bottom: 1px solid #f1f1f1;">
                                <th class="pl-0">ORDER</th>
                                <th>PENERIMA</th>
                                <th>WAKTU</th>
                                <th>STATUS</th>
                                <th class="text-right">BUKTI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deliveredOrdersToday as $do)
                            <tr style="border-bottom: 1px solid #f9f9f9;">
                                <td class="pl-0 font-weight-bold">#SB-{{ $do->id }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $do->user->name }}</div>
                                    <div class="small text-muted">{{ $do->address->alamat_lengkap }}</div>
                                </td>
                                <td>
                                    <div class="small">{{ $do->updated_at->format('H:i') }}</div>
                                    <div class="small text-muted">{{ $do->updated_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-success rounded-pill px-3 py-2" style="font-size: 0.65rem;">DONE</span>
                                </td>
                                <td class="text-right">
                                    @if($do->proof_image)
                                    <a href="{{ asset('storage/' . $do->proof_image) }}" target="_blank" class="btn btn-sm btn-light rounded-pill px-3">
                                        <i class="fas fa-image mr-1"></i> Lihat
                                    </a>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted mb-0">Belum ada pengantaran yang selesai hari ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn-pro-courier btn-maps-pro w-100" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`preview-${id}`).src = e.target.result;
                document.getElementById(`preview-container-${id}`).classList.remove('d-none');
                document.getElementById(`uploadPlaceholder${id}`).classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function startTracking() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition((pos) => {
                const { latitude, longitude } = pos.coords;
                $.post('/courier/location', {
                    _token: '{{ csrf_token() }}',
                    lat: latitude,
                    lng: longitude
                });
            }, null, { enableHighAccuracy: true });
        }
    }

    document.addEventListener('DOMContentLoaded', startTracking);
</script>
@endsection
