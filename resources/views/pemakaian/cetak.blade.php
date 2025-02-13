<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Rekening Listrik</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .logo img {
            width: 60px;
            margin-bottom: 10px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .info p {
            margin: 2px 0;
        }

        .date {
            text-align: right;
            font-style: italic;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="date">{{ date('d/m/Y') }}</div>

        <div class="logo">
            <img src="{{ public_path('assets/logos/logo.png') }}" alt="Logo PLN">
        </div>

        <div class="title">STRUK REKENING LISTRIK</div>

        <div class="info">
            <p><strong>Nama:</strong> {{ $pemakaian->pelanggan->nama }}</p>
            <p><strong>Alamat:</strong> {{ $pemakaian->pelanggan->alamat }}</p>
            <p><strong>No. Kontrol:</strong> {{ $pemakaian->no_kontrol }}</p>
            <p><strong>Bulan/Tahun:</strong> {{ $pemakaian->bulan }}/{{ $pemakaian->tahun }}</p>
            <p><strong>Meter Awal:</strong> {{ $pemakaian->meter_awal }}</p>
            <p><strong>Meter Akhir:</strong> {{ $pemakaian->meter_akhir }}</p>
            <p><strong>Jumlah Pemakaian:</strong> {{ $pemakaian->jumlah_pakai }} kWh</p>
            <div class="line"></div>
            <p><strong>Biaya Beban:</strong> Rp {{ number_format($pemakaian->biaya_beban, 0, ',', '.') }}</p>
            <p><strong>Biaya Pemakaian:</strong> Rp {{ number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</p>
            <div class="line"></div>
            <p><strong>Rekening Pembayaran:</strong></p>
            <p>Bank BCA: 1234567890</p>
            <p>Bank Mandiri: 9876543210</p>
        </div>

        <div class="footer">
            <p>Terima kasih telah melakukan pembayaran.</p>
            <p>Perusahaan Listrik Nasional</p>
        </div>
    </div>
</body>

</html>
