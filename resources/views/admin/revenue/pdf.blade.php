<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan SweetBite</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #5D4037; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #5D4037; }
        .title { font-size: 18px; margin-top: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #5D4037; color: white; padding: 10px; text-align: left; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 12px; }
        .total-box { margin-top: 30px; padding: 20px; background-color: #f9f9f9; text-align: right; border-radius: 10px; }
        .total-label { font-size: 14px; color: #666; }
        .total-amount { font-size: 20px; font-weight: bold; color: #5D4037; }
        .footer { margin-top: 50px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SweetBite Patisserie</div>
        <div class="title">LAPORAN PENDAPATAN</div>
        <div style="margin-top: 5px;">Periode: {{ $label }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID PESANAN</th>
                <th>TANGGAL</th>
                <th>CUSTOMER</th>
                <th style="text-align: right;">NOMINAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>#SB-{{ $t->id }}</td>
                <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $t->user->name }}</td>
                <td style="text-align: right;">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div class="total-label">Total Pendapatan Bersih</div>
        <div class="total-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d M Y, H:i:s') }}<br>
        SweetBite Patisserie - Gourmet Desserts & Cakes
    </div>
</body>
</html>
