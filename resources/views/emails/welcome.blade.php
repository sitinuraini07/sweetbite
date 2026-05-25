<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di SweetBite! 🍰</title>
    <style>
        body {
            background-color: #FAF6F0;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #2C1E1A;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #FAF6F0;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(92, 61, 46, 0.05);
            overflow: hidden;
            border: 1px solid rgba(216, 75, 111, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #4A2E2B 0%, #2A1715 100%);
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }
        .header h1 {
            color: #FF8E9E;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 32px;
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header p {
            color: #FAF6F0;
            font-size: 14px;
            margin: 8px 0 0 0;
            opacity: 0.9;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #4A2E2B;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .lead-text {
            font-size: 16px;
            line-height: 1.6;
            color: #554440;
            margin-bottom: 30px;
        }
        .features-box {
            background-color: #FFF8F9;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 35px;
            border-left: 4px solid #D84B6F;
        }
        .features-title {
            font-weight: 700;
            font-size: 16px;
            color: #D84B6F;
            margin-top: 0;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .feature-item {
            margin-bottom: 12px;
            font-size: 15px;
            line-height: 1.5;
            color: #554440;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-emoji {
            margin-right: 8px;
        }
        .cta-container {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #D84B6F;
            color: #ffffff !important;
            padding: 14px 32px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            border-radius: 30px;
            display: inline-block;
            box-shadow: 0 6px 20px rgba(216, 75, 111, 0.3);
            transition: all 0.3s ease;
        }
        .footer {
            background-color: #FAF6F0;
            text-align: center;
            padding: 30px 20px;
            border-top: 1px solid rgba(92, 61, 46, 0.05);
        }
        .footer p {
            margin: 0;
            font-size: 13px;
            color: #8C7A76;
            line-height: 1.5;
        }
        .footer-logo {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            color: #4A2E2B;
            font-size: 18px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <!-- Header -->
            <div class="header">
                <h1>SweetBite</h1>
                <p>Desserts &amp; Sweetness Delivered</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <div class="greeting">Halo, {{ $user->name }}! 👋</div>
                <div class="lead-text">
                    Selamat datang di <strong>SweetBite</strong>! Kami sangat gembira menyambut Anda dalam komunitas penikmat hidangan manis kami. Di sini, setiap hari adalah hari yang sempurna untuk menikmati kelezatan kue, dessert, dan kudapan manis terbaik.
                </div>
                
                <div class="features-box">
                    <div class="features-title">Manfaat Spesial Untuk Anda:</div>
                    <div class="feature-item">
                        <span class="feature-emoji">🍰</span><strong>Pilihan Premium:</strong> Menikmati ratusan pilihan dessert lezat yang dipanggang dengan bahan-bahan terbaik.
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">⚡</span><strong>Pengantaran Cepat &amp; Aman:</strong> Kurir khusus kami siap mengantarkan pesanan Anda tetap segar sampai ke depan pintu.
                    </div>
                    <div class="feature-item">
                        <span class="feature-emoji">💖</span><strong>Promo &amp; Diskon Menarik:</strong> Dapatkan potongan harga spesial di hari-hari tertentu khusus pelanggan terdaftar.
                    </div>
                </div>

                <div class="cta-container">
                    <a href="{{ url('/') }}" class="btn" target="_blank">Mulai Pesan Sekarang</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <div class="footer-logo">SweetBite</div>
                <p>Sent with love from the SweetBite Kitchen.</p>
                <p style="margin-top: 10px; font-size: 11px; opacity: 0.8;">
                    &copy; {{ date('Y') }} SweetBite. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
