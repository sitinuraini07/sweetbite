@extends('layouts.app')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        padding: 5rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 4rem;
        min-height: 80vh;
    }

    .hero-content {
        flex: 1;
    }

    .hero-content h1 {
        font-size: 5.5rem;
        line-height: 0.95;
        margin-bottom: 2.5rem;
        font-weight: 900;
        letter-spacing: -2px;
    }

    .hero-content h1 span {
        color: var(--secondary);
        display: block;
        font-style: italic;
    }

    .hero-content p {
        font-size: 1.2rem;
        color: var(--primary);
        margin-bottom: 3rem;
        max-width: 500px;
        opacity: 0.8;
    }

    .hero-image {
        flex: 1;
        position: relative;
    }

    .hero-image img {
        width: 100%;
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        box-shadow: 20px 20px 60px rgba(107, 62, 38, 0.15);
        animation: morph 8s ease-in-out infinite;
    }

    @keyframes morph {
        0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; }
        100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    }

    /* Product Cards */
    .section-title {
        text-align: center;
        margin-bottom: 5rem;
    }

    .section-title h2 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 320px));
        gap: 3rem;
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem;
        justify-content: center;
    }

    .product-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        text-align: center;
        border: 1px solid rgba(107, 62, 38, 0.05);
        max-width: 320px;
        width: 100%;
    }

    .product-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--shadow-lg);
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
    }

    .product-card h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .product-card .price {
        color: var(--secondary);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        display: block;
    }

    .btn-add {
        background: var(--primary);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add:hover {
        background: var(--secondary);
        transform: rotate(90deg) scale(1.1);
    }

    /* Floating Icons Animation */
    .floating-fruit {
        position: absolute;
        opacity: 0.2;
        z-index: -1;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(15deg); }
    }

    @media (max-width: 768px) {
        .hero {
            flex-direction: column;
            text-align: center;
            padding-top: 8rem;
        }
        .hero-content h1 {
            font-size: 3.5rem;
        }
        .hero-image {
            width: 100%;
        }
        
        .about-section {
            flex-direction: column !important;
            padding: 5rem 1.5rem !important;
            gap: 3rem !important;
        }
        .about-title {
            font-size: 2.5rem !important;
        }
        .contact-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
        .contact-section {
            padding: 5rem 1.5rem !important;
            margin-top: 2rem !important;
        }
        .badge-box {
            position: relative !important;
            bottom: auto !important;
            right: auto !important;
            margin: -40px auto 0 !important;
            z-index: 10;
        }

        /* 2-Column Product Grid on Mobile */
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1.25rem !important;
            padding: 1rem !important;
        }
        .product-card {
            padding: 1rem !important;
            max-width: 100% !important;
        }
        .product-card img {
            height: 130px !important;
            margin-bottom: 1rem !important;
        }
        .product-card h3 {
            font-size: 1.1rem !important;
            margin-bottom: 0.4rem !important;
        }
        .product-card .price {
            font-size: 1.05rem !important;
            margin-bottom: 1rem !important;
        }
        .btn-add {
            width: 40px !important;
            height: 40px !important;
        }
    }
    
    .about-section {
        padding: 10rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 6rem;
    }
    .about-title {
        font-size: 3.5rem;
        margin-bottom: 2rem;
    }
    .contact-section {
        padding: 8rem 2rem;
        background: var(--white);
        margin-top: 5rem;
        border-radius: 60px 60px 0 0;
    }
    .contact-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .badge-box {
        position: absolute;
        bottom: -30px;
        right: -30px;
        background: var(--secondary);
        color: white;
        padding: 2.5rem 2rem;
        border-radius: 2rem;
        box-shadow: var(--shadow-lg);
        max-width: 250px;
        text-align: center;
        border: 4px solid white;
    }

    /* Promo Banner */
    .promo-section {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .promo-banner {
        width: 100%;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform 0.3s ease;
        position: relative;
    }

    .promo-banner:hover {
        transform: scale(1.02);
    }

    .promo-banner img {
        width: 100%;
        display: block;
        height: auto;
        min-height: 150px;
        object-fit: cover;
    }

    .promo-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--secondary);
        color: white;
        padding: 8px 20px;
        border-radius: 100px;
        font-weight: 800;
        font-size: 0.8rem;
        box-shadow: 0 10px 20px rgba(242, 140, 171, 0.3);
        z-index: 2;
    }

    .promo-slider {
        display: flex;
        gap: 2rem;
        overflow-x: auto;
        padding: 1rem 0;
        scrollbar-width: none;
    }
    .promo-slider::-webkit-scrollbar { display: none; }
</style>
@endsection

@section('content')
<!-- Floating Decorations -->
<div class="floating-fruit" style="top: 15%; left: 5%; font-size: 3rem;">🍓</div>
<div class="floating-fruit" style="top: 60%; right: 5%; font-size: 4rem; animation-delay: 2s;">🧁</div>
<div class="floating-fruit" style="bottom: 10%; left: 10%; font-size: 2.5rem; animation-delay: 4s;">🍩</div>

<section class="hero">
    <div class="hero-content animate-fade">
        <h1>Sweet Moments, <span>Made for You</span></h1>
        <p>Rasakan simfoni rasa yang diciptakan oleh pastry chef ahli kami. Setiap gigitan adalah perayaan kebahagiaan yang tak terlupakan.</p>
        <div style="display: flex; gap: 1.5rem; justify-content: flex-start;" class="mobile-center">
            <a href="/products" class="btn-pill btn-secondary">Order Now</a>
            <a href="#about" class="btn-pill btn-outline">Our Story</a>
        </div>
    </div>
    <div class="hero-image animate-fade" style="animation-delay: 0.2s;">
        <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Delicious Dessert">
    </div>
</section>

<!-- Promo Section (Dynamic) -->
@if(isset($discounts) && $discounts->count() > 0)
<section class="promo-section animate-fade">
    <div class="promo-slider">
        @foreach($discounts as $d)
            @if($d->banner_image)
            <div class="promo-banner" style="flex: 0 0 100%; max-width: 1200px;">
                <div class="promo-badge">{{ $d->name }}</div>
                <img src="{{ asset('storage/' . $d->banner_image) }}" alt="{{ $d->name }}">
            </div>
            @endif
        @endforeach
    </div>
</section>
@endif



<section id="menu" style="padding: 10rem 0; background: var(--white); border-radius: 80px 80px 0 0; box-shadow: 0 -40px 80px rgba(107, 62, 38, 0.03);">
    <div class="section-title">
        <p style="color: var(--secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">Menu Pilihan</p>
        <h2>Signature Creations</h2>
    </div>

    <div class="product-grid">
        @forelse($products->take(3) as $product)
            <div class="product-card">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' }}" alt="{{ $product->name }}">
                <p style="color: var(--secondary); font-size: 0.8rem; font-weight: 600;">{{ $product->category->name ?? 'Dessert' }}</p>
                <h3>{{ $product->name }}</h3>
                <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <form action="/cart/add/{{ $product->id }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add">
                        <i data-lucide="plus" style="width: 24px;"></i>
                    </button>
                </form>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                <p style="color: var(--primary); font-size: 1.2rem;">Belum ada produk yang tersedia. ✨</p>
            </div>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 5rem;">
        <a href="/products" class="btn-pill btn-outline">Lihat Semua Menu &rarr;</a>
    </div>
</section>

<section id="about" class="about-section">
    <div style="flex: 1; position: relative; width: 100%;">
        <img src="{{ asset('img/about_chef.png') }}" alt="Baking with Love" style="width: 100%; border-radius: 2.5rem; box-shadow: var(--shadow-lg); object-fit: cover; height: 420px;">
        <div class="badge-box">
            <i class="fas fa-cookie-bite fa-3x" style="color: white; margin-bottom: 1.2rem; display: block;"></i>
            <h4 style="font-size: 1.5rem; margin-bottom: 0.5rem; font-weight: 700;">Sejak 2010</h4>
            <p style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0; font-weight: 500;">Kualitas Premium yang Terjaga.</p>
        </div>
    </div>
    <div style="flex: 1;">
        <p style="color: var(--secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">Cerita Kami</p>
        <h2 class="about-title">Purity in Every Ingredient.</h2>
        <p style="font-size: 1.1rem; color: var(--primary); opacity: 0.8; margin-bottom: 1.5rem;">SweetBite dimulai dari sebuah dapur kecil di garasi rumah pada tahun 2010. Berawal dari hobi sang pemilik yang sangat mencintai seni kuliner, khususnya hidangan penutup premium.</p>
        <p style="font-size: 1.1rem; color: var(--primary); opacity: 0.8; margin-bottom: 1.5rem;">Visi kami sederhana: ingin menghadirkan kebahagiaan melalui setiap gigitan cake yang lembut dan lezat. Kami percaya bahwa setiap perayaan kecil layak mendapatkan sentuhan manis yang istimewa.</p>
        <p style="font-size: 1.1rem; color: var(--primary); opacity: 0.8;">Hingga kini, kami tetap konsisten menggunakan 100% bahan organik, tanpa pengawet, dan setiap pesanan dibuat secara *fresh* demi menjaga kualitas rasa yang autentik.</p>
    </div>
</section>

<section id="contact" class="contact-section">
    <div class="contact-grid">
        <div>
            <h2 class="font-heading" style="font-size: 3rem; margin-bottom: 1.5rem;">Kunjungi Toko Kami</h2>
            <p style="color: var(--text-muted); margin-bottom: 2.5rem;">Kami selalu senang menyambut Anda. Datang dan rasakan langsung kehangatan dapur kami.</p>
            <div style="display: grid; gap: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="background: var(--bg-soft); padding: 1rem; border-radius: 1rem; color: var(--secondary);"><i data-lucide="map-pin"></i></div>
                    <div>
                        <h4 style="font-weight: 700;">Lokasi</h4>
                        <p style="color: var(--text-muted);">Jl. Manis Sekali No. 123, Jakarta Selatan</p>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="background: var(--bg-soft); padding: 1rem; border-radius: 1rem; color: var(--secondary);"><i data-lucide="clock"></i></div>
                    <div>
                        <h4 style="font-weight: 700;">Jam Operasional</h4>
                        <p style="color: var(--text-muted);">Senin - Minggu: 09:00 - 21:00</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="background: var(--bg-soft); padding: 3rem; border-radius: 2rem;">
            <h3 class="font-heading" style="margin-bottom: 1.5rem;">Kirim Pesan</h3>
            <form style="display: grid; gap: 1rem;">
                <input type="text" placeholder="Nama Anda" style="padding: 1rem; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05);">
                <input type="email" placeholder="Email Anda" style="padding: 1rem; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05);">
                <textarea placeholder="Pesan Anda" style="padding: 1rem; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); height: 120px;"></textarea>
                <button type="button" class="btn-pill btn-secondary">Kirim Sekarang</button>
            </form>
        </div>
    </div>
</section>

@endsection
