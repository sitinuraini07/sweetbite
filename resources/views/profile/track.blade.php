@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    :root {
        --gojek-green: #00AA13;
        --gojek-dark: #222222;
        --sweet-pink: #F28CAB;
        --sweet-brown: #5D4037;
    }

    body {
        background-color: #f0f2f5;
    }

    .track-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 6rem 1rem 5rem;
    }

    .track-main-card {
        background: white;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 30px 100px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }

    .track-map-wrapper {
        position: relative;
        height: 550px;
        width: 100%;
        background: #e5e3df;
    }

    .map-overlay-status {
        position: absolute;
        top: 25px;
        left: 25px;
        z-index: 1000;
    }

    .status-chip-premium {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 12px 25px;
        border-radius: 100px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        font-size: 0.85rem;
        color: var(--gojek-green);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(0, 170, 19, 0.1);
    }

    .pulse-indicator {
        width: 10px;
        height: 10px;
        background: var(--gojek-green);
        border-radius: 50%;
        animation: pulse-ring 2s infinite;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(0, 170, 19, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 15px rgba(0, 170, 19, 0); }
        100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(0, 170, 19, 0); }
    }

    .track-content-sheet {
        padding: 3rem;
        background: white;
    }

    .tracking-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 3rem;
    }

    .courier-card-mini {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        background: #F9FAFB;
        padding: 1.2rem 2rem;
        border-radius: 25px;
        border: 1px solid #F1F1F1;
    }

    .courier-avatar-mini {
        width: 60px;
        height: 60px;
        background: var(--gojek-green);
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 170, 19, 0.2);
    }

    .courier-info-mini h5 {
        margin: 0;
        font-weight: 800;
        color: var(--gojek-dark);
        font-size: 1.1rem;
    }

    .courier-info-mini p {
        margin: 0;
        font-size: 0.85rem;
        color: #777;
    }

    .order-stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4rem;
        position: relative;
        padding: 0 2rem;
    }

    .order-stepper::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 4rem;
        right: 4rem;
        height: 3px;
        background: #eee;
        z-index: 1;
    }

    .step-item {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 120px;
    }

    .step-circle {
        width: 54px;
        height: 54px;
        background: #f0f0f0;
        color: #bbb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 4px solid white;
    }

    .step-item.active .step-circle {
        background: var(--gojek-green);
        color: white;
        transform: scale(1.15);
        box-shadow: 0 10px 25px rgba(0, 170, 19, 0.2);
    }

    .step-item.completed .step-circle {
        background: #E8F5E9;
        color: var(--gojek-green);
    }

    .step-label {
        font-size: 0.8rem;
        font-weight: 800;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .step-item.active .step-label {
        color: var(--gojek-dark);
    }

    .proof-of-delivery-section {
        background: #F9FAFB;
        border-radius: 35px;
        padding: 2.5rem;
        margin-bottom: 3rem;
        text-align: center;
    }

    .proof-image-container {
        margin-top: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .proof-image-container img {
        max-width: 100%;
        border-radius: 25px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.1);
        border: 5px solid white;
    }

    .action-grid-track {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .btn-track-action {
        padding: 1.3rem;
        border-radius: 22px;
        font-weight: 800;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s;
        border: none;
    }

    .btn-confirm-success {
        background: var(--gojek-green);
        color: white;
        box-shadow: 0 12px 30px rgba(0, 170, 19, 0.3);
    }

    .btn-confirm-success:hover {
        transform: translateY(-5px);
        background: #008810;
        box-shadow: 0 18px 40px rgba(0, 170, 19, 0.4);
    }

    .btn-complain {
        background: white;
        color: #E53935;
        border: 2px solid #E53935;
    }

    .btn-complain:hover {
        background: #FFEBEE;
        transform: translateY(-5px);
    }

    /* Map Markers */
    .leaflet-routing-container { display: none !important; }

    #btnFollowCourier {
        background: white;
        color: var(--gojek-green);
        border: 1px solid rgba(0, 170, 19, 0.15);
        cursor: pointer;
    }
    #btnFollowCourier.active {
        background: var(--gojek-green);
        color: white;
        box-shadow: 0 10px 25px rgba(0, 170, 19, 0.3);
    }

    @media (max-width: 768px) {
        .order-stepper { overflow-x: auto; padding-bottom: 1rem; }
        .action-grid-track { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="track-container">
    <div class="track-main-card animate-fade">
        <!-- Map Section -->
        <div class="track-map-wrapper">
            <div class="map-overlay-status">
                <div class="status-chip-premium">
                    <div class="pulse-indicator"></div>
                    @if($transaction->status === 'shipping') 
                        PAKET SEDANG DIANTAR
                    @elseif($transaction->status === 'delivered') 
                        PAKET TELAH SAMPAI
                    @elseif($transaction->status === 'completed')
                        PESANAN SELESAI
                    @else
                        PESANAN DIPROSES
                    @endif
                </div>
            </div>
            <div id="trackMap" style="height: 100%; width: 100%;"></div>
            
            <!-- Floating follow button -->
            <button id="btnFollowCourier" class="btn btn-sm shadow-sm active" style="position: absolute; bottom: 25px; right: 25px; z-index: 1000; border-radius: 100px; font-weight: 800; font-size: 0.8rem; display: none; align-items: center; gap: 8px; padding: 12px 24px; transition: all 0.3s;">
                <i class="fas fa-crosshairs"></i> <span>Ikuti Kurir</span>
            </button>
        </div>

        <!-- Content Section -->
        <div class="track-content-sheet">
            <div class="tracking-header">
                <div>
                    <h2 class="font-weight-bold mb-1" style="color: var(--gojek-dark)">Lacak Pesanan</h2>
                    <p class="text-muted small mb-2">ID Pesanan: <strong>#SB-{{ $transaction->id }}</strong></p>
                    
                    @if(in_array($transaction->status, ['confirmed', 'shipping', 'delivered', 'completed', 'pending']))
                    <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill shadow-sm" style="background: #E8F5E9; border: 1px solid #C8E6C9; gap: 8px;">
                        <i class="fas fa-history" style="color: var(--gojek-green); font-size: 0.9rem;"></i>
                        <span style="font-size: 0.8rem; font-weight: 800; color: #2E7D32;">
                            {{ $transaction->estimated_arrival }}
                        </span>
                    </div>
                    @endif
                </div>
                
                @if($transaction->courier)
                <div class="courier-card-mini">
                    <div class="courier-avatar-mini">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="courier-info-mini">
                        <p>Kurir Anda</p>
                        <h5>{{ $transaction->courier->name }}</h5>
                    </div>
                    <a href="tel:{{ $transaction->courier->phone_number ?? '#' }}" class="ml-3 btn btn-white rounded-circle shadow-sm p-2" style="color: var(--gojek-green)">
                        <i class="fas fa-phone-alt"></i>
                    </a>
                </div>
                @endif
            </div>

            @if($transaction->admin_note)
            <div class="alert alert-info border-0 shadow-sm mb-5 p-4 animate-fade" style="border-radius: 25px; background: #E1F5FE; color: #0277BD;">
                <div class="d-flex align-items-center">
                    <div class="mr-4 text-info">
                        <i class="fas fa-info-circle fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold mb-1">Pesan dari Admin SweetBite</h6>
                        <p class="mb-0 small">{{ $transaction->admin_note }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Modern Stepper -->
            <div class="order-stepper">
                <div class="step-item completed">
                    <div class="step-circle"><i class="fas fa-utensils"></i></div>
                    <div class="step-label">Diproses</div>
                </div>
                <div class="step-item {{ in_array($transaction->status, ['shipping', 'delivered', 'completed']) ? 'active' : '' }} {{ in_array($transaction->status, ['delivered', 'completed']) ? 'completed' : '' }}">
                    <div class="step-circle"><i class="fas fa-motorcycle"></i></div>
                    <div class="step-label">Dikirim</div>
                </div>
                <div class="step-item {{ in_array($transaction->status, ['delivered', 'completed']) ? 'active' : '' }} {{ $transaction->status === 'completed' ? 'completed' : '' }}">
                    <div class="step-circle"><i class="fas fa-home"></i></div>
                    <div class="step-label">Sampai</div>
                </div>
                <div class="step-item {{ $transaction->status === 'completed' ? 'active completed' : '' }}">
                    <div class="step-circle"><i class="fas fa-check-double"></i></div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>

            <!-- Proof of Delivery -->
            @if($transaction->proof_image && $transaction->status === 'delivered')
            <div class="proof-of-delivery-section" data-aos="zoom-in">
                <div class="h5 font-weight-bold mb-0">Bukti Pengiriman</div>
                <p class="text-muted small">Kurir telah mengunggah foto paket Anda.</p>
                
                <div class="proof-image-container">
                    <img src="{{ asset('storage/' . $transaction->proof_image) }}" alt="Proof of Delivery">
                </div>

                <div class="mt-4 alert alert-warning rounded-pill px-4 small border-0 text-dark">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Mohon pastikan paket sudah Anda terima dengan baik sebelum konfirmasi.
                </div>

                <div class="action-grid-track mt-5">
                    <form action="{{ route('profile.confirm', $transaction->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-track-action btn-confirm-success w-100">
                            Konfirmasi Pesanan Diterima
                        </button>
                    </form>
                    <button type="button" class="btn-track-action btn-complain w-100" data-toggle="modal" data-target="#refundModal">
                        Ajukan Komplain / Refund
                    </button>
                </div>
            </div>
            @elseif(in_array($transaction->status, ['pending', 'confirmed', 'shipping']))
            <div class="text-center py-4">
                <p class="text-muted small mb-3">Pesanan Anda sedang kami siapkan. Jika ada kendala atau pesanan tidak kunjung sampai, Anda dapat mengajukan refund.</p>
                <button type="button" class="btn btn-outline-danger rounded-pill px-5 font-weight-bold" data-toggle="modal" data-target="#refundModal">
                    Batalkan / Ajukan Refund
                </button>
            </div>
            @endif

            @if($transaction->status === 'completed')
            <div class="text-center py-5 bg-light rounded-pill mb-4">
                <div class="h4 font-weight-bold text-success mb-2"><i class="fas fa-check-circle mr-2"></i> Pesanan Telah Selesai</div>
                <p class="text-muted mb-0">Dikonfirmasi pada {{ $transaction->customer_confirmed_at ? \Carbon\Carbon::parse($transaction->customer_confirmed_at)->format('d M Y, H:i') : '-' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Refund (Same as before) -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 35px; border: none; padding: 1.5rem;">
      <div class="modal-header border-0">
        <h5 class="modal-title font-weight-bold">Formulir Komplain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('profile.refund', $transaction->id) }}" method="POST">
          @csrf
          <div class="modal-body border-0">
            <p class="text-muted small mb-4">Mohon tuliskan kendala yang Anda alami agar kami dapat membantu proses pengembalian dana.</p>
            <textarea name="refund_reason" class="form-control" rows="4" placeholder="Contoh: Pesanan tertukar atau kemasan rusak..." style="border-radius: 20px; background: #f8f9fa; padding: 1.2rem;" required></textarea>
          </div>
          <div class="modal-footer border-0">
            <button type="submit" class="btn btn-danger btn-block rounded-pill py-3 font-weight-bold shadow-sm">Kirim Pengajuan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const storeLoc = [-6.3456, 106.7890];
        
        // Safely fetch destination latitude and longitude
        const destLat = @json($transaction->address->latitude);
        const destLng = @json($transaction->address->longitude);
        const destLoc = (destLat && destLng) ? [parseFloat(destLat), parseFloat(destLng)] : storeLoc;
        
        // Set initial view to destLoc if coordinates exist, otherwise storeLoc
        const map = L.map('trackMap', { 
            zoomControl: false,
            dragging: true 
        }).setView(destLoc, 15);

        // Google Maps Style Tiles
        L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            attribution: '© Google'
        }).addTo(map);

        const storeIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/3081/3081559.png',
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });

        const homeIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/1946/1946436.png',
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });

        const bikeIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/3721/3721619.png',
            iconSize: [45, 45],
            iconAnchor: [22, 22]
        });

        let courierMarker = null;
        let followCourier = true;

        // Draw static markers
        L.marker(storeLoc, { icon: storeIcon }).addTo(map).bindPopup('<b>SweetBite Store</b>');
        if (destLat && destLng) {
            L.marker(destLoc, { icon: homeIcon }).addTo(map).bindPopup('<b>Lokasi Kamu</b>');
        }

        // Draw static route line for reference
        const staticLine = L.polyline([storeLoc, destLoc], {
            color: '#00AA13', 
            weight: 3, 
            opacity: 0.6, 
            dashArray: '5, 10'
        }).addTo(map);

        // Fit map bounds to show store and destination initially
        const initialBounds = L.latLngBounds([storeLoc, destLoc]);
        map.fitBounds(initialBounds, { padding: [50, 50] });

        function fetchLocation() {
            $.get('{{ route('profile.courier_location', $transaction->id) }}', function(data) {
                if (data.lat && data.lng) {
                    const newPos = [parseFloat(data.lat), parseFloat(data.lng)];
                    
                    if (!courierMarker) {
                        courierMarker = L.marker(newPos, { icon: bikeIcon, zIndexOffset: 1000 })
                            .addTo(map)
                            .bindPopup('<b>Kurir sedang dijalan</b>');
                        
                        // Show the follow button now that courier is active
                        $('#btnFollowCourier').css('display', 'flex');
                        
                        // First time we get the courier location, fit bounds to show everyone
                        const bounds = L.latLngBounds([storeLoc, destLoc, newPos]);
                        map.fitBounds(bounds, { padding: [50, 50] });
                    } else {
                        courierMarker.setLatLng(newPos);
                    }
                    
                    if (followCourier) {
                        map.panTo(newPos);
                    }
                }

                // If finished, stop polling
                if (data.status !== 'shipping') {
                    clearInterval(trackingInterval);
                    if (data.status === 'delivered') {
                        location.reload(); // Refresh to show proof
                    }
                }
            });
        }

        // Disable follow mode when user manually drags/interacts with map
        map.on('dragstart', function() {
            followCourier = false;
            $('#btnFollowCourier').removeClass('active');
        });

        // Toggle/Enable follow mode when clicking floating button
        $('#btnFollowCourier').on('click', function() {
            followCourier = true;
            $(this).addClass('active');
            if (courierMarker) {
                map.panTo(courierMarker.getLatLng());
            }
        });

        // Start Polling every 3 seconds
        const trackingInterval = setInterval(fetchLocation, 3000);
        fetchLocation(); // Initial call

        // Ensure map renders correctly
        setTimeout(() => {
            map.invalidateSize();
        }, 800);
    });
</script>
@endsection
