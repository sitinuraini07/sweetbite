<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBite - {{ $title }}</title>
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
            padding-top: 30px;
            padding-bottom: 35px;
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
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: #FF8E9E;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }
        .header p {
            color: #FAF6F0;
            font-size: 13px;
            margin: 6px 0 0 0;
            opacity: 0.9;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 30px 24px;
            background-color: #ffffff;
        }
        .status-badge-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .status-badge {
            background-color: #FFF2F4;
            color: #D84B6F;
            font-weight: 700;
            font-size: 14px;
            padding: 8px 18px;
            border-radius: 20px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(216, 75, 111, 0.2);
        }
        .title {
            font-size: 20px;
            font-weight: 700;
            color: #4A2E2B;
            margin-top: 0;
            margin-bottom: 12px;
            text-align: center;
        }
        .desc {
            font-size: 15px;
            line-height: 1.6;
            color: #554440;
            margin-bottom: 25px;
            text-align: center;
        }
        
        /* Note Card */
        .note-card {
            background-color: #FFFDF9;
            border: 1px dashed #E5C3B2;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
        }
        .note-title {
            font-weight: 700;
            font-size: 13px;
            color: #8A5A44;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .note-body {
            font-size: 14px;
            line-height: 1.5;
            color: #5C3D2E;
            font-style: italic;
        }

        /* Order Details Table */
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .order-table th {
            text-align: left;
            padding-bottom: 10px;
            border-bottom: 2px solid #F3ECE5;
            color: #8C7A76;
            font-size: 13px;
            text-transform: uppercase;
        }
        .order-table td {
            padding: 12px 0;
            border-bottom: 1px solid #FAF6F0;
            font-size: 14px;
        }
        .product-name {
            font-weight: 600;
            color: #4A2E2B;
        }
        .product-qty {
            color: #8C7A76;
        }
        
        /* Financial Calculation Card */
        .calc-section {
            background-color: #FAF6F0;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 25px;
        }
        .calc-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            font-size: 14px;
            color: #554440;
        }
        .calc-row:last-child {
            margin-bottom: 0;
        }
        .calc-label {
            display: table-cell;
            text-align: left;
        }
        .calc-value {
            display: table-cell;
            text-align: right;
            font-weight: 500;
        }
        .calc-total {
            border-top: 1.5px solid #E5DCD3;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: 700;
            font-size: 16px;
            color: #4A2E2B;
        }

        /* Address and Delivery Info */
        .info-grid {
            margin-bottom: 30px;
            font-size: 14px;
            color: #554440;
            line-height: 1.5;
        }
        .info-title {
            font-weight: 700;
            color: #4A2E2B;
            margin-bottom: 6px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-card {
            border: 1px solid #FAF6F0;
            border-radius: 12px;
            padding: 16px;
            background-color: #FFFDF9;
        }

        .cta-container {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .btn {
            background-color: #D84B6F;
            color: #ffffff !important;
            padding: 12px 28px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            border-radius: 30px;
            display: inline-block;
            box-shadow: 0 6px 16px rgba(216, 75, 111, 0.25);
        }
        .footer {
            background-color: #FAF6F0;
            text-align: center;
            padding: 25px 20px;
            border-top: 1px solid rgba(92, 61, 46, 0.05);
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #8C7A76;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <!-- Header -->
            <div class="header">
                <h1>SweetBite</h1>
                <p>Pesanan Anda</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <div class="status-badge-container">
                    <span class="status-badge">Order #{{ $transaction->id }}</span>
                </div>
                
                <div class="title">{{ $title }}</div>
                <div class="desc">{{ $description }}</div>

                <!-- Admin Note (If available) -->
                @if($note)
                <div class="note-card">
                    <div class="note-title">Catatan Toko:</div>
                    <div class="note-body">"{{ $note }}"</div>
                </div>
                @endif

                <!-- Items Purchased -->
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th style="text-align: center; width: 60px;">Jumlah</th>
                            <th style="text-align: right; width: 120px;">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($transaction->details as $detail)
                        @php $subtotal += $detail->price * $detail->quantity; @endphp
                        <tr>
                            <td>
                                <span class="product-name">{{ $detail->product->name ?? 'Produk' }}</span>
                            </td>
                            <td style="text-align: center;" class="product-qty">
                                {{ $detail->quantity }}x
                            </td>
                            <td style="text-align: right;" class="product-name">
                                Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary Calculations -->
                <div class="calc-section">
                    <div class="calc-row">
                        <div class="calc-label">Subtotal</div>
                        <div class="calc-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                    @if($transaction->discount > 0)
                    <div class="calc-row" style="color: #D84B6F;">
                        <div class="calc-label">Diskon</div>
                        <div class="calc-value">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</div>
                    </div>
                    @endif
                    <div class="calc-row">
                        <div class="calc-label">Ongkos Kirim</div>
                        <div class="calc-value">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</div>
                    </div>
                    <div class="calc-row">
                        <div class="calc-label">Pajak (PPN 11%)</div>
                        <div class="calc-value">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</div>
                    </div>
                    <div class="calc-row calc-total">
                        <div class="calc-label">Total Pembayaran</div>
                        <div class="calc-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="info-grid">
                    <div class="info-title">Alamat Pengiriman</div>
                    <div class="info-card">
                        <strong>{{ $transaction->user->name }}</strong><br>
                        {{ $transaction->address->alamat_lengkap ?? '' }}<br>
                        {{ $transaction->address->village ?? '' }}, {{ $transaction->address->district ?? '' }}<br>
                        {{ $transaction->address->regency ?? '' }}, {{ $transaction->address->province ?? '' }} {{ $transaction->address->postal_code ?? '' }}<br>
                        <span style="color: #8C7A76;">Telp: {{ $transaction->address->phone_number ?? '' }}</span>
                    </div>
                </div>

                <div class="cta-container">
                    <a href="{{ url('/my-orders/'.$transaction->id.'/track') }}" class="btn" target="_blank">Lacak Pesanan Anda</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>Terima kasih telah mempercayakan kebahagiaan manis Anda kepada kami!</p>
                <p style="margin-top: 8px; font-size: 11px; opacity: 0.8;">
                    Butuh bantuan? Hubungi kami di <a href="mailto:support@sweetbite.com" style="color: #D84B6F; text-decoration: none;">support@sweetbite.com</a>
                </p>
                <p style="margin-top: 10px; font-size: 11px; opacity: 0.6;">
                    &copy; {{ date('Y') }} SweetBite. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
