<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBite - Gourmet Patisserie</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Bootstrap 4 & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <style>
        :root {
            --primary: #6B3E26; /* Deep Cocoa */
            --secondary: #F28CAB; /* Strawberry Cream */
            --accent: #D97D99; /* Muted Berry */
            --bg-soft: #FFF9F6; /* Warm Pearl */
            --dark-choco: #2D1B18; /* Rich Espresso */
            --white: #FFFFFF;
            --text-main: #3E2723;
            --text-muted: #8D7773;
            --radius-lg: 24px;
            --radius-md: 16px;
            --shadow-sm: 0 4px 20px rgba(107, 62, 38, 0.04);
            --shadow-md: 0 10px 40px rgba(107, 62, 38, 0.08);
            --shadow-lg: 0 20px 60px rgba(107, 62, 38, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        h1, h2, h3, .font-heading {
            font-family: 'Playfair Display', serif;
            color: var(--dark-choco);
        }

        body {
            background-color: var(--bg-soft);
            background-image: url("https://www.transparenttextures.com/patterns/p6.png"); /* Subtle paper texture */
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar */
        #main-nav {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 60px);
            max-width: 1200px;
            z-index: 1100;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(25px) saturate(200%);
            -webkit-backdrop-filter: blur(25px) saturate(200%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 100px;
            box-shadow: 0 10px 40px rgba(107, 62, 38, 0.05);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        }

        #main-nav.scrolled {
            top: 15px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 50px rgba(107, 62, 38, 0.12);
            width: calc(100% - 40px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.8rem 2.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .logo img {
            height: 45px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: rotate(-10deg) scale(1.1);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--secondary);
        }

        .nav-links {
            display: flex;
            gap: 1.2rem;
            align-items: center;
        }

        .nav-item {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0.2rem;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .nav-item:hover {
            color: var(--secondary);
            text-decoration: none;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        /* Admin Nav Styles */
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1.2rem;
            border-radius: 100px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(107, 62, 38, 0.03);
        }

        .admin-nav-link i {
            font-size: 1rem;
            color: var(--secondary);
        }

        .admin-nav-link:hover {
            background: rgba(242, 140, 171, 0.15);
            color: var(--secondary);
            text-decoration: none;
        }

        .admin-nav-link.active {
            background: var(--primary);
            color: var(--white);
        }

        .admin-nav-link.active i {
            color: var(--white);
        }

        .logout-link {
            color: var(--secondary);
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 100px;
            border: 1px solid rgba(242, 140, 171, 0.2);
        }

        .logout-link:hover {
            background: rgba(242, 140, 171, 0.05);
            color: #d81b60;
            text-decoration: none;
        }

        .btn-cart-circle {
            background: var(--white);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(107, 62, 38, 0.1);
            color: var(--primary);
            transition: all 0.3s;
            border: 1px solid rgba(107, 62, 38, 0.05);
        }

        .btn-cart-circle:hover {
            transform: scale(1.1) rotate(-10deg);
            background: var(--secondary);
            color: var(--white);
        }

        .btn-pill {
            padding: 0.8rem 2.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--white);
            box-shadow: 0 8px 25px rgba(242, 140, 171, 0.3);
        }

        .btn-secondary:hover {
            background: #e07a9a;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(242, 140, 171, 0.4);
        }

        main {
            padding-top: 10rem;
            min-height: 85vh;
            padding-bottom: 5rem;
        }

        footer {
            background: var(--dark-choco);
            color: #E0CFCB;
            padding: 8rem 2rem 4rem;
            position: relative;
            overflow: hidden;
            border-radius: 60px 60px 0 0;
            margin-top: 5rem;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 4rem;
            position: relative;
            z-index: 2;
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--white);
            margin-bottom: 1.5rem;
            display: block;
            text-decoration: none;
        }

        .footer-logo span {
            color: var(--secondary);
        }

        .dripping-choco {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: var(--dark-choco);
            clip-path: polygon(0 0, 100% 0, 100% 70%, 95% 85%, 90% 70%, 85% 95%, 80% 70%, 75% 85%, 70% 70%, 65% 90%, 60% 70%, 55% 80%, 50% 70%, 45% 95%, 40% 70%, 35% 85%, 30% 70%, 25% 90%, 20% 70%, 15% 80%, 10% 70%, 5% 95%, 0 70%);
            z-index: 1;
        }

        .rounded-pill-left {
            border-top-left-radius: 50px !important;
            border-bottom-left-radius: 50px !important;
        }
        .rounded-pill-right {
            border-top-right-radius: 50px !important;
            border-bottom-right-radius: 50px !important;
        }

        .mobile-drawer-header {
            display: none;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
            z-index: 1200;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: var(--primary);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .table-responsive {
            overflow-x: auto !important;
            padding-bottom: 5px; /* space for scrollbar */
        }

        .table-responsive table th,
        .table-responsive table td {
            white-space: nowrap !important;
        }

        /* Custom Scrollbar at the bottom of table */
        .table-responsive::-webkit-scrollbar {
            height: 10px;
            -webkit-appearance: none;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: rgba(107, 62, 38, 0.1);
            border-radius: 10px;
            margin: 0 15px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(107, 62, 38, 0.5);
            border-radius: 10px;
            border: 2px solid #fff;
        }
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: rgba(107, 62, 38, 0.8);
        }

        @media (max-width: 992px) {
            .nav-container { padding: 0.8rem 1.2rem; }
            .logo-text { font-size: 1.4rem; }
            .nav-links { gap: 0.8rem; }
            .admin-nav-link { padding: 0.5rem 0.8rem; font-size: 0.8rem; }
            .admin-nav-link span { display: none; }
        }

        @media (max-width: 768px) {
            #main-nav { top: 10px; width: calc(100% - 20px); }
            .hamburger { display: flex; }
            
            /* Hide hamburger when active because we show a dedicated close button inside drawer */
            .hamburger.active {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }

            /* Make form search and add button side-by-side on mobile */
            .mobile-drawer-header {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 100%;
            }

            .container > .d-flex.justify-content-between.align-items-center,
            .container-fluid > .d-flex.justify-content-between.align-items-center {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .container > .d-flex.justify-content-between .d-flex.gap-3,
            .container-fluid > .d-flex.justify-content-between .d-flex.gap-3 {
                flex-wrap: nowrap !important;
                width: 100%;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem !important;
            }
            .container > .d-flex.justify-content-between .d-flex.gap-3 form,
            .container-fluid > .d-flex.justify-content-between .d-flex.gap-3 form {
                flex-grow: 1;
                margin-right: 0 !important;
                margin-bottom: 0;
            }
            .container > .d-flex.justify-content-between .d-flex.gap-3 form .input-group,
            .container-fluid > .d-flex.justify-content-between .d-flex.gap-3 form .input-group {
                width: 100%;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: -300px;
                width: 290px;
                height: 100vh;
                background: var(--bg-soft);
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem;
                gap: 1.2rem;
                box-shadow: -5px 0 25px rgba(0,0,0,0.1);
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1100;
                overflow-y: auto;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links > .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                width: 100%;
                gap: 0.6rem !important;
            }

            .admin-nav-link {
                width: 100%;
                justify-content: flex-start;
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
                background: transparent;
                border-radius: 12px;
                color: var(--primary);
            }
            .admin-nav-link:hover {
                background: rgba(242, 140, 171, 0.1);
                color: var(--secondary);
            }
            .admin-nav-link.active {
                background: var(--primary);
                color: var(--white);
            }

            .logout-link {
                width: 100%;
                justify-content: flex-start;
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
                margin-left: 0 !important;
                border-radius: 12px;
                border-color: rgba(242, 140, 171, 0.4);
            }

            .nav-item {
                width: 100%;
                justify-content: flex-start;
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
                border-radius: 12px;
                color: var(--primary);
                display: block;
            }
            .nav-item:hover {
                background: rgba(242, 140, 171, 0.1);
                color: var(--secondary);
                text-decoration: none;
            }
            .nav-item::after {
                display: none;
            }

            .admin-nav-link span { display: inline; }
            
            .btn-cart-circle { margin-left: 0 !important; margin-bottom: 0.5rem; }

            main { padding-top: 6rem; padding-bottom: 2rem; }
            
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: left;
            }
            .footer-grid ul { justify-items: start; }
            .footer-grid li { justify-content: flex-start; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav id="main-nav">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="SweetBite Logo">
                <div class="logo-text">Sweet<span>Bite</span></div>
            </a>

            <!-- Hamburger Menu Button -->
            <button class="hamburger" id="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Overlay -->
            <div class="sidebar-overlay" id="sidebar-overlay"></div>

            <div class="nav-links" id="nav-links">
                <!-- Mobile Drawer Header -->
                <div class="mobile-drawer-header mb-4 pb-3 border-bottom" style="border-bottom-color: rgba(107, 62, 38, 0.1) !important;">
                    <span class="logo-text font-heading" style="font-size: 1.4rem; font-weight: 800; color: var(--primary);">Sweet<span style="color: var(--secondary);">Bite</span></span>
                    <button class="border-0 bg-transparent text-chocolate p-0" id="drawer-close-btn" style="font-size: 1.4rem; cursor: pointer; color: var(--primary); outline: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if(!Auth::check() || (Auth::check() && Auth::user()->role === 'customer'))
                    <a href="/" class="nav-item">Home</a>
                    <a href="/products" class="nav-item">Menu</a>
                    <a href="/#about" class="nav-item">About</a>
                    <a href="/#contact" class="nav-item">Contact</a>
                    <a href="/cart" class="btn-cart-circle position-relative ml-2">
                        <i data-lucide="shopping-cart" style="width: 20px;"></i>
                        <span id="cart-badge" class="badge badge-pill badge-secondary position-absolute {{ (isset($cartCount) && $cartCount > 0) ? '' : 'd-none' }}" style="top: -5px; right: -5px; font-size: 0.7rem; border: 2px solid white;">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>
                @endif

                @auth
                    @if(Auth::user()->role === 'admin')
                        <div class="d-flex align-items-center" style="gap: 0.5rem;">
                            <a href="/admin/dashboard" class="admin-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i> <span>Dashboard</span>
                            </a>
                            <a href="/admin/orders" class="admin-nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag"></i> <span>Pesanan</span>
                            </a>
                            <a href="/admin/products" class="admin-nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                                <i class="fas fa-cookie-bite"></i> <span>Produk</span>
                            </a>
                            <a href="/admin/categories" class="admin-nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                                <i class="fas fa-tags"></i> <span>Kategori</span>
                            </a>
                            <a href="/admin/revenue" class="admin-nav-link {{ request()->is('admin/revenue*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice-dollar"></i> <span>Laporan</span>
                            </a>
                            <a href="/admin/couriers" class="admin-nav-link {{ request()->is('admin/couriers*') ? 'active' : '' }}">
                                <i class="fas fa-motorcycle"></i> <span>Kurir</span>
                            </a>
                            <a href="/admin/discounts" class="admin-nav-link {{ request()->is('admin/discounts*') ? 'active' : '' }}">
                                <i class="fas fa-percentage"></i> <span>Diskon</span>
                            </a>
                            <a href="/logout" class="logout-link ml-3">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    @elseif(Auth::user()->role === 'courier')
                        <div class="d-flex align-items-center" style="gap: 1.5rem;">
                            <a href="/courier/orders" class="admin-nav-link">
                                <i class="fas fa-motorcycle"></i> <span>Tugas Kurir</span>
                            </a>
                            <a href="/logout" class="logout-link">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    @else
                        <div class="d-flex align-items-center" style="gap: 1.2rem;">
                            <!-- Notification Icon -->
                            <a href="#" class="btn-cart-circle position-relative ml-2" data-toggle="modal" data-target="#notificationModal">
                                <i data-lucide="mail" style="width: 20px;"></i>
                                @if($unreadNotesCount > 0)
                                     <span class="badge badge-pill badge-danger position-absolute" style="top: -5px; right: -5px; font-size: 0.6rem; border: 2px solid white;">
                                        {{ $unreadNotesCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('profile.orders') }}" class="nav-item ml-2">Pesanan Saya</a>
                            <a href="/profile" class="nav-item font-weight-bold">Profil</a>
                            <a href="/logout" class="logout-link">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    @endif
                    <form id="logout-form" action="/logout" method="POST" style="display:none;">
                        @csrf
                    </form>
                @else
                    <a href="/login" class="nav-item ml-2">Login</a>
                    <a href="/register" class="btn-pill btn-secondary py-2 px-4 shadow-sm" style="margin-left: 0.5rem;">Join Now</a>
                @endauth
            </div>
        </div>
        </div>
    </nav>


    <main>
        @yield('content')
    </main>

    <footer>
        <div class="dripping-choco"></div>
        <div class="footer-grid">
            <div>
                <a href="/" class="footer-logo">Sweet<span>Bite</span></a>
                <p>Menciptakan momen manis di setiap gigitan. Dibuat dengan cinta dan bahan-bahan pilihan terbaik. 🍓🍫</p>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="#" style="color: white;"><i data-lucide="instagram"></i></a>
                    <a href="#" style="color: white;"><i data-lucide="facebook"></i></a>
                    <a href="#" style="color: white;"><i data-lucide="twitter"></i></a>
                </div>
            </div>
            <div>
                <h3 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem;">Quick Links</h3>
                <ul style="list-style: none; display: grid; gap: 0.8rem;">
                    <li><a href="/products" style="color: inherit; text-decoration: none;">Menu Dessert</a></li>
                    <li><a href="#" style="color: inherit; text-decoration: none;">Best Seller</a></li>
                    <li><a href="#" style="color: inherit; text-decoration: none;">Special Order</a></li>
                    <li><a href="#" style="color: inherit; text-decoration: none;">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div>
                <h3 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem;">Hubungi Kami</h3>
                <ul style="list-style: none; display: grid; gap: 1rem;">
                    <li style="display: flex; gap: 0.8rem; align-items: center;"><i data-lucide="map-pin" style="width: 20px; color: var(--secondary);"></i> Jl. Manis Sekali No. 123, Jakarta</li>
                    <li style="display: flex; gap: 0.8rem; align-items: center;"><i data-lucide="phone" style="width: 20px; color: var(--secondary);"></i> +62 812 3456 789</li>
                    <li style="display: flex; gap: 0.8rem; align-items: center;"><i data-lucide="mail" style="width: 20px; color: var(--secondary);"></i> hello@sweetbite.com</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.5); font-size: 0.9rem;">
            &copy; 2026 SweetBite Patisserie. All rights reserved. ✨
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            lucide.createIcons();

            // Initialize Bootstrap Tooltips
            $('[data-toggle="tooltip"], [data-tooltip="tooltip"]').tooltip();

            // Mobile Menu Toggle
            const mobileBtn = $('#mobile-menu-btn');
            const navLinks = $('#nav-links');
            const overlay = $('#sidebar-overlay');

            function toggleMenu() {
                mobileBtn.toggleClass('active');
                navLinks.toggleClass('active');
                overlay.toggleClass('active');
                $('body').toggleClass('overflow-hidden');
            }

            mobileBtn.on('click', toggleMenu);
            overlay.on('click', toggleMenu);
            $('#drawer-close-btn').on('click', toggleMenu);

            // Close menu when a link is clicked
            $('.nav-item, .admin-nav-link, .logout-link').on('click', function(e) {
                if ($(window).width() <= 768 && !$(this).hasClass('btn-cart-circle') && $(this).attr('data-toggle') !== 'modal') {
                    toggleMenu();
                }
            });

            // Scroll Effect for Navbar
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('main-nav');
                if (nav) {
                    if (window.scrollY > 50) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                }
            });

            // Mark notifications as read when modal is shown
            $('#notificationModal').on('shown.bs.modal', function () {
                $.ajax({
                    url: '/notifications/mark-as-read',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('.badge-danger').fadeOut();
                    }
                });
            });
        });
    </script>
    @yield('scripts')

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 35px;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold" style="color: var(--primary);">
                        <i class="fas fa-bell mr-2 text-warning"></i> Pesan Admin
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    @if(isset($notifications) && $notifications->count() > 0)
                        @foreach($notifications as $notif)
                            <div class="p-3 mb-3 {{ $notif->is_note_read ? 'bg-light' : 'bg-white border-primary' }}" style="border-radius: 20px; border: 1px solid #f1f1f1; position: relative; transition: all 0.3s;">
                                @if(!$notif->is_note_read)
                                    <span class="position-absolute" style="top: 15px; right: 15px; width: 10px; height: 10px; background: var(--secondary); border-radius: 50%; box-shadow: 0 0 10px rgba(242, 140, 171, 0.5);"></span>
                                @endif
                                <div class="small text-muted mb-2 d-flex justify-content-between font-weight-bold">
                                    <span>#SB-{{ $notif->id }}</span>
                                    <span>{{ $notif->updated_at->diffForHumans() }}</span>
                                </div>
                                <p class="mb-0" style="color: var(--dark-choco); font-size: 0.85rem; line-height: 1.5;">{{ $notif->admin_note }}</p>
                                <a href="{{ route('profile.track', $notif->id) }}" class="stretched-link"></a>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pesan.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-block btn-pill btn-outline-secondary py-2" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
