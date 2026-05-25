@extends('layouts.app')

@section('styles')
<style>
    :root {
        --card-bg: rgba(255, 255, 255, 0.9);
        --accent-soft: rgba(242, 140, 171, 0.1);
    }

    .cart-header {
        padding: 4rem 0 3rem;
        text-align: center;
    }

    .cart-header h1 {
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 1rem;
    }

    .cart-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2.5rem;
        align-items: start;
    }

    .cart-items-wrapper {
        display: grid;
        gap: 1.5rem;
    }

    .cart-item-card {
        background: white;
        border-radius: 30px;
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 140px 1fr auto;
        gap: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(107, 62, 38, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .cart-item-img-container {
        width: 140px;
        height: 140px;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    .cart-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        background: var(--accent-soft);
        color: var(--secondary);
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.8rem;
        width: fit-content;
    }

    .item-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--dark-choco);
    }

    .item-price {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 1rem;
    }

    .qty-control-wrapper {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .qty-input-group {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border-radius: 100px;
        padding: 4px;
        border: 1px solid #eee;
    }

    .qty-input {
        width: 50px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    .qty-input:focus {
        outline: none;
    }

    .btn-update-inline {
        color: var(--secondary);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        transition: all 0.3s;
    }

    .btn-update-inline:hover {
        color: var(--primary);
        transform: scale(1.05);
    }

    .btn-remove-item {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #fff0f0;
        color: #ff6b6b;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
    }

    .btn-remove-item:hover {
        background: #ff6b6b;
        color: white;
        transform: rotate(90deg);
    }

    .subtotal-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: right;
        min-width: 120px;
    }

    .subtotal-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
    }

    .subtotal-amount {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }

    .summary-card {
        background: white;
        border-radius: 35px;
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(107, 62, 38, 0.05);
        position: sticky;
        top: 120px;
    }

    .summary-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        position: relative;
        padding-bottom: 1rem;
    }

    .summary-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: var(--secondary);
        border-radius: 10px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.2rem;
        font-weight: 500;
    }

    .summary-total {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px dashed #eee;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .total-amount {
        font-size: 2rem;
        font-weight: 900;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }

    .btn-checkout {
        width: 100%;
        margin-top: 2.5rem;
        padding: 1.2rem;
        border-radius: 20px;
        background: var(--primary);
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(107, 62, 38, 0.2);
        text-decoration: none;
    }

    .btn-checkout:hover {
        background: var(--dark-choco);
        transform: scale(1.02);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 1100px) {
        .cart-container {
            grid-template-columns: 1fr;
        }
        .summary-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .cart-item-card {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            text-align: center;
        }
        .cart-item-img-container {
            margin: 0 auto;
        }
        .category-badge { margin: 0 auto 0.8rem; }
        .qty-control-wrapper { justify-content: center; }
        .subtotal-section { text-align: center; margin-top: 1rem; border-top: 1px solid #eee; padding-top: 1.5rem; }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="cart-header" data-aos="fade-up">
        <h1 class="font-heading display-4">Keranjang Manis</h1>
        <p class="text-muted">Setiap pilihan Anda adalah langkah menuju kebahagiaan yang sempurna.</p>
    </div>

    @if(!$cart || $cart->items->isEmpty())
        <div class="text-center py-5" data-aos="zoom-in">
            <div class="mb-4">
                <div style="background: var(--accent-soft); width: 150px; height: 150px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i data-lucide="shopping-bag" style="width: 60px; height: 60px; color: var(--secondary);"></i>
                </div>
            </div>
            <h2 class="font-heading mb-3">Keranjang Masih Kosong</h2>
            <p class="text-muted mb-5">Dapur kami sedang harum oleh aroma panggangan kue. <br>Mari intip menu spesial hari ini!</p>
            <a href="/products" class="btn-pill btn-secondary px-5 py-3">Jelajahi Menu ✨</a>
        </div>
    @else
        <div class="cart-container">
            <!-- List Item -->
            <div class="cart-items-wrapper">
                @php $total = 0; @endphp
                @foreach($cart->items as $item)
                    <div class="cart-item-card" data-aos="fade-right">
                        <form action="/cart/remove/{{ $item->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove-item" title="Hapus Item">
                                <i data-lucide="x" style="width: 18px;"></i>
                            </button>
                        </form>

                        <div class="cart-item-img-container">
                            @if($item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="cart-item-img" alt="{{ $item->product->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?q=80&w=800&auto=format&fit=crop" class="cart-item-img" alt="SweetBite">
                            @endif
                        </div>
                        
                        <div class="cart-item-info">
                            <span class="category-badge">{{ $item->product->category->name ?? 'Dessert' }}</span>
                            <h3 class="item-name">{{ $item->product->name }}</h3>
                            <div class="item-price">Rp <span class="unit-price" data-price="{{ $item->product->price }}">{{ number_format($item->product->price, 0, ',', '.') }}</span></div>
                            
                            <div class="qty-control-wrapper">
                                <form action="/cart/update/{{ $item->id }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <div class="qty-input-group mr-3">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input" data-id="{{ $item->id }}">
                                    </div>
                                    <button type="submit" class="btn-update-inline">Update</button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="subtotal-section">
                            <span class="subtotal-label">Subtotal</span>
                            <div class="subtotal-amount subtotal-price" data-subtotal="{{ $item->product->price * $item->quantity }}">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @php $total += $item->product->price * $item->quantity; @endphp
                @endforeach
            </div>

            <!-- Summary Card -->
            <div class="summary-wrapper" data-aos="fade-left">
                <div class="summary-card">
                    <h2 class="font-heading summary-title">Ringkasan</h2>
                    
                    <div class="summary-row">
                        <span class="text-muted">Total Harga Produk</span>
                        <span id="summary-total-price" class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="text-muted">Biaya Pengiriman</span>
                        <span class="text-success font-weight-bold">Gratis</span>
                    </div>

                    <div class="summary-row">
                        <span class="text-muted">Voucher Diskon</span>
                        <span class="text-secondary">-</span>
                    </div>
                    
                    <div class="summary-total">
                        <div class="total-label">Total Bayar</div>
                        <div class="total-amount" id="summary-final-total">Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>

                    <a href="/checkout" class="btn-checkout">
                        <span>Lanjut ke Checkout</span>
                        <i data-lucide="arrow-right" style="width: 20px;"></i>
                    </a>

                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <i data-lucide="shield-check" class="mr-2" style="width: 16px; color: var(--secondary);"></i>
                            Pembayaran Aman & Terenkripsi
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i data-lucide="truck" class="mr-2" style="width: 16px; color: var(--secondary);"></i>
                            Pengiriman Cepat & Terjamin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        lucide.createIcons();

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number).replace('Rp', 'Rp ');
        }

        $('.qty-input').on('change input', function() {
            const qty = parseInt($(this).val()) || 1;
            const $item = $(this).closest('.cart-item-card');
            const unitPrice = parseFloat($item.find('.unit-price').data('price'));
            
            // Update Subtotal for this item
            const subtotal = qty * unitPrice;
            $item.find('.subtotal-price').data('subtotal', subtotal);
            $item.find('.subtotal-price').text(formatRupiah(subtotal));

            // Update Total
            updateGrandTotal();
        });

        function updateGrandTotal() {
            let total = 0;
            $('.subtotal-price').each(function() {
                total += parseFloat($(this).data('subtotal'));
            });

            $('#summary-total-price').text(formatRupiah(total));
            $('#summary-final-total').text(formatRupiah(total));

            // Update Badge (Count unique items/rows, like Shopee)
            const totalItems = $('.cart-item-card').length;
            const $badge = $('#cart-badge');
            const $badgeMobile = $('#cart-badge-mobile');
            
            $badge.text(totalItems);
            $badgeMobile.text(totalItems);

            if (totalItems > 0) {
                $badge.removeClass('d-none');
                $badgeMobile.removeClass('d-none');
            } else {
                $badge.addClass('d-none');
                $badgeMobile.addClass('d-none');
            }
        }
    });
</script>
@endsection
