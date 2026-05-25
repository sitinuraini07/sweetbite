<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        .header-title { font-size: 18pt; font-weight: bold; color: #5D4037; text-align: center; }
        .header-subtitle { font-size: 13pt; font-weight: bold; color: #666666; text-align: center; }
        .header-period { font-size: 10pt; color: #999999; text-align: center; }
        th {
            background-color: #5D4037;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 10pt;
            padding: 8px;
            text-align: left;
            border: 1px solid #5D4037;
        }
        td {
            padding: 6px 8px;
            font-size: 10pt;
            border: 1px solid #DDDDDD;
        }
        .row-alt { background-color: #F9F9F9; }
        .nominal { text-align: right; }
        .total-label {
            font-size: 11pt;
            font-weight: bold;
            color: #5D4037;
            text-align: right;
        }
        .total-amount {
            font-size: 13pt;
            font-weight: bold;
            color: #5D4037;
            text-align: right;
        }
        .footer { font-size: 8pt; color: #999999; font-style: italic; text-align: center; }
    </style>
</head>
<body>
    <table>
        {{-- Header --}}
        <tr>
            <td colspan="4" class="header-title">SweetBite Patisserie</td>
        </tr>
        <tr>
            <td colspan="4" class="header-subtitle">LAPORAN PENDAPATAN</td>
        </tr>
        <tr>
            <td colspan="4" class="header-period">Periode: {{ $label }}</td>
        </tr>
        <tr><td colspan="4"></td></tr>

        {{-- Table Header --}}
        <tr>
            <th>ID PESANAN</th>
            <th>TANGGAL</th>
            <th>CUSTOMER</th>
            <th>NOMINAL</th>
        </tr>

        {{-- Data Rows --}}
        @foreach($transactions as $index => $t)
        <tr class="{{ $index % 2 == 1 ? 'row-alt' : '' }}">
            <td>#SB-{{ $t->id }}</td>
            <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
            <td>{{ $t->user->name }}</td>
            <td class="nominal">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
        </tr>
        @endforeach

        {{-- Empty row --}}
        <tr><td colspan="4"></td></tr>

        {{-- Total --}}
        <tr>
            <td colspan="2"></td>
            <td class="total-label">Total Pendapatan Bersih:</td>
            <td class="total-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
        </tr>

        {{-- Empty row --}}
        <tr><td colspan="4"></td></tr>

        {{-- Footer --}}
        <tr>
            <td colspan="4" class="footer">Dicetak pada: {{ date('d M Y, H:i:s') }} | SweetBite Patisserie - Gourmet Desserts & Cakes</td>
        </tr>
    </table>
</body>
</html>
