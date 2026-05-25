@extends('layouts.app')

@section('styles')
<style>
    .menu-header {
        text-align: center;
        padding: 4rem 0;
        background: linear-gradient(rgba(255,249,246,0.5), rgba(255,249,246,1));
        border-radius: 0 0 60px 60px;
        margin-bottom: 4rem;
    }

    .menu-header h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 300px));
        gap: 2.5rem;
        padding: 2rem 0;
        justify-content: center;
    }

    .product-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(107, 62, 38, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        max-width: 300px;
    }

    .product-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--shadow-lg);
    }

    .product-image {
        position: relative;
        width: 100%;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-info {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        color: var(--secondary);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.8rem;
    }

    .product-name {
        font-size: 1.4rem;
        font-family: 'Playfair Display', serif;
        color: var(--dark-choco);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .product-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
    }

    .add-to-cart-btn {
        background: var(--primary);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(107, 62, 38, 0.2);
    }

    .add-to-cart-btn:hover {
        background: var(--secondary);
        transform: rotate(90deg);
        box-shadow: 0 6px 15px rgba(242, 140, 171, 0.4);
    }

    .btn-buy-now {
        background: var(--secondary);
        color: white;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border: none;
        box-shadow: 0 4px 15px rgba(242, 140, 171, 0.2);
        transition: all 0.3s;
        cursor: pointer;
    }

    .btn-buy-now:hover {
        background: #e07a9a;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(242, 140, 171, 0.3);
    }

    @media (max-width: 768px) {
        .menu-header h1 { font-size: 2.5rem; }
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem !important;
            padding: 1rem 0.5rem !important;
        }
        .product-card {
            max-width: 100% !important;
        }
        .product-info {
            padding: 1rem !important;
        }
        .product-name {
            font-size: 1.1rem !important;
            margin-bottom: 0.8rem !important;
        }
        .product-category {
            font-size: 0.7rem !important;
            margin-bottom: 0.4rem !important;
        }
        .product-footer {
            flex-direction: column !important;
            align-items: center !important;
            gap: 0.5rem !important;
            padding-top: 0.5rem !important;
        }
        .product-footer .d-flex {
            justify-content: center !important;
            width: 100% !important;
            gap: 0.5rem !important;
        }
        .product-price {
            font-size: 1.05rem !important;
            text-align: center;
        }
        .add-to-cart-btn {
            width: 36px !important;
            height: 36px !important;
            flex-shrink: 0;
        }
        .btn-buy-now {
            padding: 0.4rem 1.2rem !important;
            font-size: 0.7rem !important;
            flex-grow: 1;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="menu-header">
    <div class="container">
        <h1>Our Menu</h1>
        <p class="text-muted">Jelajahi koleksi hidangan penutup artisanal kami yang dibuat dengan cinta.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="product-grid">
        @foreach($products as $product)
        <div class="product-card">
            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?q=80&w=800&auto=format&fit=crop" alt="SweetBite Default">
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">{{ $product->category->name ?? 'Specialty' }}</div>
                <h3 class="product-name">{{ $product->name }}</h3>
                <div class="product-footer">
                    <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <div class="d-flex gap-2">
                        <form action="/cart/add/{{ $product->id }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <button type="submit" class="add-to-cart-btn" title="Tambah ke Keranjang">
                                <i data-lucide="shopping-cart" style="width: 18px;"></i>
                            </button>
                        </form>
                        <form action="/buy-now/{{ $product->id }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-buy-now">Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const url = form.attr('action');
            const btn = form.find('button');
            
            // Visual feedback
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin" style="width: 18px;"></i>');
            
            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        // Update cart badges
                        const badge = $('#cart-badge');
                        const badgeMobile = $('#cart-badge-mobile');
                        
                        if(badge.length) badge.text(response.cart_count).removeClass('d-none');
                        if(badgeMobile.length) badgeMobile.text(response.cart_count).removeClass('d-none');
                        
                        // Re-trigger lucide icons
                        if(typeof lucide !== 'undefined') lucide.createIcons();
                        
                        // Smoothly reset button with "success" state
                        setTimeout(() => {
                            btn.prop('disabled', false);
                            btn.css('background', '#4CAF50'); // Green
                            btn.html('<i data-lucide="check" style="width: 18px;"></i>');
                            lucide.createIcons();
                            
                            setTimeout(() => {
                                btn.css('background', ''); // Reset to original
                                btn.html('<i data-lucide="shopping-cart" style="width: 18px;"></i>');
                                lucide.createIcons();
                            }, 1500);
                        }, 500);
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan!';
                    alert(msg);
                    btn.prop('disabled', false);
                    btn.html('<i data-lucide="shopping-cart" style="width: 18px;"></i>');
                    lucide.createIcons();
                }
            });
        });
    });
</script>
@endsection