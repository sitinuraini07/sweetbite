@extends('layouts.app')

@section('styles')
<style>
    .checkout-wrapper {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
        align-items: start;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: var(--dark-choco);
        position: relative;
        padding-bottom: 0.8rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--secondary);
        border-radius: 10px;
    }

    .checkout-card {
        background: white;
        border-radius: 35px;
        padding: 3rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(107, 62, 38, 0.05);
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 0.8rem;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.5rem;
        border-radius: 18px;
        border: 1.5px solid #f0f0f0;
        background: #fbfbfb;
        color: var(--dark-choco);
        font-weight: 500;
        transition: all 0.3s;
    }

    .form-input:focus {
        background: white;
        border-color: var(--secondary);
        box-shadow: 0 8px 25px rgba(242, 140, 171, 0.1);
        outline: none;
    }

    .form-input::placeholder {
        color: #ccc;
    }

    .form-input:disabled {
        background: #f5f5f5;
        color: #999;
    }

    .order-item {
        display: flex;
        gap: 1.2rem;
        padding-bottom: 1.2rem;
        margin-bottom: 1.2rem;
        border-bottom: 1px dashed #eee;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-img {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        object-fit: cover;
        box-shadow: var(--shadow-sm);
    }

    .order-item-info {
        flex-grow: 1;
    }

    .order-item-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.95rem;
        margin-bottom: 0.2rem;
    }

    .order-item-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .checkout-summary-card {
        background: var(--primary);
        color: white;
        border-radius: 35px;
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        position: sticky;
        top: 120px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .promo-line {
        background: rgba(255,255,255,0.1);
        padding: 10px 15px;
        border-radius: 15px;
        margin: 1.5rem 0;
        opacity: 1;
        font-weight: 700;
        color: #fff;
    }

    .summary-divider {
        height: 1px;
        background: rgba(255,255,255,0.1);
        margin: 1.5rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .total-label {
        font-weight: 600;
        font-size: 1rem;
    }

    .total-value {
        font-size: 1.8rem;
        font-weight: 900;
        font-family: 'Playfair Display', serif;
    }

    .btn-pay {
        width: 100%;
        background: var(--secondary);
        color: white;
        border: none;
        padding: 1.2rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(242, 140, 171, 0.3);
    }

    .btn-pay:hover {
        transform: translateY(-5px);
        background: #e07a9a;
        box-shadow: 0 15px 40px rgba(242, 140, 171, 0.4);
    }

    .breadcrumb-custom {
        display: flex;
        gap: 0.8rem;
        list-style: none;
        padding: 0;
        margin-bottom: 2.5rem;
    }

    .breadcrumb-custom li {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .breadcrumb-custom li.active {
        color: var(--secondary);
    }

    .breadcrumb-custom li:not(:last-child)::after {
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 0.7rem;
        opacity: 0.5;
    }

    @media (max-width: 992px) {
        .checkout-wrapper {
            grid-template-columns: 1fr;
        }
        .checkout-summary-card {
            position: static;
        }
    }
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0f0f0;
        padding: 0.3rem 0.6rem;
        border-radius: 100px;
        width: fit-content;
    }

    .btn-qty {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: none;
        background: white;
        color: var(--primary);
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-qty:hover {
        background: var(--secondary);
        color: white;
    }

    .summary-line.grand-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.2);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom" data-aos="fade-down">
        <li><a href="/cart" class="text-decoration-none" style="color: inherit;">Keranjang</a></li>
        <li class="active">Checkout</li>
        <li>Konfirmasi</li>
    </ul>

    @if($couriers_busy)
    <div class="alert alert-warning border-0 shadow-sm mb-5 animate-fade" style="border-radius: 25px; background: #FFFDE7; border: 1px solid #FFF59D;">
        <div class="d-flex align-items-center p-3">
            <div class="mr-4 text-warning">
                <i class="fas fa-motorcycle fa-2x"></i>
            </div>
            <div>
                <h5 class="font-weight-bold mb-1" style="color: #827717;">Kurir Kami Sedang Sibuk Melayani Pelanggan Lain</h5>
                <p class="mb-0 small" style="color: #9E9D24;">Semua armada pengiriman sedang berada di perjalanan. Anda tetap dapat memesan, namun mohon pengertiannya jika ada sedikit keterlambatan. Terima kasih telah bersabar! 🙏</p>
            </div>
        </div>
    </div>
    @endif

    <form action="/checkout" method="POST">
        @csrf
        @if(isset($buy_now) && $buy_now)
            <input type="hidden" name="product_id" value="{{ $cart->items->first()->product_id }}">
            <input type="hidden" name="qty" value="{{ $cart->items->first()->quantity }}">
        @endif
        <div class="checkout-wrapper">
            <!-- Left Side: Shipping Info -->
            <div data-aos="fade-right">
                <div class="checkout-card mb-5">
                    <h2 class="section-title">Informasi Pengiriman</h2>
                    
                    <div class="mb-4">
                        <label class="form-label">Penerima Pesanan</label>
                        <input type="text" value="{{ Auth::user()->name }}" class="form-input" disabled>
                        <small class="text-muted mt-2 d-block">Nama profil Anda digunakan sebagai nama penerima.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="phone" class="form-input" placeholder="Misal: 081234567890" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-input" placeholder="12345" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Provinsi</label>
                            <select id="province_select" class="form-input" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <input type="hidden" name="province" id="province_name">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kota / Kabupaten</label>
                            <select id="regency_select" class="form-input" required disabled>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                            <input type="hidden" name="regency" id="regency_name">
                            <input type="hidden" name="city" id="city_name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kecamatan</label>
                            <select id="district_select" class="form-input" required disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <input type="hidden" name="district" id="district_name">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kelurahan / Desa</label>
                            <select id="village_select" class="form-input" required disabled>
                                <option value="">Pilih Kelurahan</option>
                            </select>
                            <input type="hidden" name="village" id="village_name">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat Lengkap (Jalan, No. Rumah, RT/RW)</label>
                        <textarea name="address" class="form-input" rows="3" placeholder="Contoh: Jl. Melati No. 12, RT 05 RW 02" required></textarea>
                    </div>
                </div>

                <div class="checkout-card" data-aos="fade-right" data-aos-delay="100">
                    <h2 class="section-title">Detail Pesanan</h2>
                    <div class="order-list">
                        @php $runningSubtotal = 0; @endphp
                        @foreach($cart->items as $item)
                        <div class="order-item">
                            @if($item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="order-item-img" alt="{{ $item->product->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?q=80&w=800&auto=format&fit=crop" class="order-item-img" alt="SweetBite">
                            @endif
                            <div class="order-item-info">
                                <div class="order-item-name">{{ $item->product->name }}</div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="quantity-control">
                                        <button type="button" class="btn-qty decrease-qty" data-id="{{ $item->product_id }}">-</button>
                                        <span class="qty-display mx-2" id="qty-{{ $item->product_id }}">{{ $item->quantity }}</span>
                                        <button type="button" class="btn-qty increase-qty" data-id="{{ $item->product_id }}">+</button>
                                    </div>
                                    <div class="order-item-meta ml-3">x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="order-item-price font-weight-bold" style="color: var(--primary);">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                        @php $runningSubtotal += $item->product->price * $item->quantity; @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Side: Summary & Payment -->
            <div class="summary-wrapper" data-aos="fade-left">
                <div class="checkout-summary-card">
                    <h3 class="font-heading mb-4 text-white">Ringkasan Pembayaran</h3>
                    
                    <div class="summary-line">
                        <span>Total Produk</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-line">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-line">
                        <span>Pajak (11%)</span>
                        <span>+ Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>

                    @if($discount > 0)
                    <div class="summary-line promo-line">
                        <span><i class="fas fa-tag mr-2"></i> Diskon {{ $activeDiscount ? '('.$activeDiscount->name.')' : '' }}</span>
                        <span class="font-weight-bold">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="summary-divider"></div>
                    
                    <div class="summary-total">
                        <div class="total-label">Total Bayar</div>
                        <div class="total-value">Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>

                    <button type="submit" class="btn-pay">
                        <span>Bayar Sekarang</span>
                        <i data-lucide="credit-card" style="width: 20px;"></i>
                    </button>

                    <div class="mt-4 text-center">
                        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/MasterCard_Logo.svg" height="20" style="opacity: 0.8;">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" height="15" style="opacity: 0.8;">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="20" style="opacity: 0.8;">
                        </div>
                        <p style="font-size: 0.75rem; opacity: 0.7; margin: 0;">
                            <i data-lucide="lock" style="width: 12px; margin-right: 4px;"></i>
                            Keamanan Anda prioritas kami. Semua data dienkripsi.
                        </p>
                    </div>
                </div>
                
                <div class="mt-4 p-4 text-center text-muted small" style="background: white; border-radius: 20px; border: 1px solid #eee;">
                    Dapatkan poin SweetBite 🍯 sebesar <strong>{{ floor($total/1000) }} poin</strong> dari pesanan ini!
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        lucide.createIcons();

        // Wilayah ID Proxy Integration (Local routes to bypass CORS)
        const regionApi = '/api/regions';

        function loadProvinces() {
            $.ajax({
                url: `${regionApi}/provinces`,
                method: 'GET',
                success: function(res) {
                    let options = '<option value="">Pilih Provinsi</option>';
                    if (res.data) {
                        res.data.forEach(p => {
                            options += `<option value="${p.code}" data-name="${p.name}">${p.name}</option>`;
                        });
                    }
                    $('#province_select').html(options);
                },
                error: function(err) {
                    console.error("Gagal memuat provinsi:", err);
                }
            });
        }

        $('#province_select').change(function() {
            const id = $(this).val();
            const name = $(this).find(':selected').data('name');
            $('#province_name').val(name);
            
            $('#regency_select, #district_select, #village_select').html('<option value="">Memuat...</option>').prop('disabled', true);
            $('#regency_name, #city_name, #district_name, #village_name').val('');

            if (id) {
                $.get(`${regionApi}/regencies/${id}`, function(res) {
                    let options = '<option value="">Pilih Kota/Kabupaten</option>';
                    if (res.data) {
                        res.data.forEach(r => {
                            options += `<option value="${r.code}" data-name="${r.name}">${r.name}</option>`;
                        });
                    }
                    $('#regency_select').html(options).prop('disabled', false);
                });
            }
        });

        $('#regency_select').change(function() {
            const id = $(this).val();
            const name = $(this).find(':selected').data('name');
            $('#regency_name').val(name);
            $('#city_name').val(name);
            
            $('#district_select, #village_select').html('<option value="">Memuat...</option>').prop('disabled', true);
            $('#district_name, #village_name').val('');

            if (id) {
                $.get(`${regionApi}/districts/${id}`, function(res) {
                    let options = '<option value="">Pilih Kecamatan</option>';
                    if (res.data) {
                        res.data.forEach(d => {
                            options += `<option value="${d.code}" data-name="${d.name}">${d.name}</option>`;
                        });
                    }
                    $('#district_select').html(options).prop('disabled', false);
                });
            }
        });

        $('#district_select').change(function() {
            const id = $(this).val();
            const name = $(this).find(':selected').data('name');
            $('#district_name').val(name);
            
            $('#village_select').html('<option value="">Memuat...</option>').prop('disabled', true);
            $('#village_name').val('');

            if (id) {
                $.get(`${regionApi}/villages/${id}`, function(res) {
                    let options = '<option value="">Pilih Kelurahan</option>';
                    if (res.data) {
                        res.data.forEach(v => {
                            options += `<option value="${v.code}" data-name="${v.name}">${v.name}</option>`;
                        });
                    }
                    $('#village_select').html(options).prop('disabled', false);
                });
            }
        });

        $('#village_select').change(function() {
            const name = $(this).find(':selected').data('name');
            $('#village_name').val(name);
        });

        loadProvinces();

        // Quantity Control
        $('.increase-qty, .decrease-qty').click(function() {
            const productId = $(this).data('id');
            const isIncrease = $(this).hasClass('increase-qty');
            let currentQty = parseInt($(`#qty-${productId}`).text());
            
            if (!isIncrease && currentQty <= 1) return;
            
            const newQty = isIncrease ? currentQty + 1 : currentQty - 1;
            
            // For "Buy Now", just reload with new qty
            @if($buy_now)
                window.location.href = `/checkout?product_id=${productId}&qty=${newQty}`;
            @else
                // For normal cart, we should update cart via AJAX then reload
                $.ajax({
                    url: '/cart/update',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: newQty
                    },
                    success: function() {
                        window.location.reload();
                    }
                });
            @endif
        });
    });
</script>
@endsection
