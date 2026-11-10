<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota {{ $transaksi->kode_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .nota-container {
            max-width: 80mm;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #333;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            margin: 3px 0;
        }
        
        .info-transaksi {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #ccc;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .items {
            margin-bottom: 15px;
        }
        
        .item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dotted #ccc;
        }
        
        .item-name {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 3px;
        }
        
        .item-detail {
            font-size: 11px;
            color: #666;
        }
        
        .item-price {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 3px;
        }
        
        .total-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #333;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .total-row.grand-total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #333;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
            font-size: 11px;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        .button-container {
            max-width: 80mm;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-print {
            background: #4A6B3D;
            color: white;
        }
        
        .btn-print:hover {
            background: #3D5A2F;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 107, 61, 0.3);
        }
        
        .btn-primary {
            background: #235347;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1a3d36;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(35, 83, 71, 0.3);
        }
        
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .nota-container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .button-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header -->
        <div class="header">
            <h1>{{ \App\Models\Pengaturan::get('toko_nama', 'SiBuku') }}</h1>
            <p>{{ \App\Models\Pengaturan::get('toko_alamat', 'Jl. Siliwangi No. 1, Cirebon') }}</p>
            <p>Telp: {{ \App\Models\Pengaturan::get('toko_telepon', '0231-000000') }}</p>
        </div>

        <!-- Info Transaksi -->
        <div class="info-transaksi">
            <div class="info-row">
                <span>No:</span>
                <span>{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="info-row">
                <span>Tgl:</span>
                <span>{{ format_tanggal_indo($transaksi->tanggal) }}</span>
            </div>
            <div class="info-row">
                <span>Kasir:</span>
                <span>{{ $transaksi->kasir->name }}</span>
            </div>
            @if($transaksi->pelanggan)
                <div class="info-row">
                    <span>Pelanggan:</span>
                    <span>{{ $transaksi->pelanggan->nama }}</span>
                </div>
            @endif
        </div>

        <!-- Items -->
        <div class="items">
            @foreach($transaksi->detail as $item)
                <div class="item">
                    <div class="item-name">{{ $item->judul_snapshot }}</div>
                    <div class="item-detail">{{ $item->kondisi_snapshot }}</div>
                    <div class="item-price">
                        <span>{{ $item->jumlah }} x {{ format_rupiah($item->harga_satuan) }}</span>
                        <span>{{ format_rupiah($item->subtotal) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal</span>
                <span>{{ format_rupiah($transaksi->total) }}</span>
            </div>
            @if($transaksi->diskon > 0)
                <div class="total-row">
                    <span>Diskon</span>
                    <span>- {{ format_rupiah($transaksi->diskon) }}</span>
                </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>{{ format_rupiah($transaksi->total_setelah_diskon) }}</span>
            </div>
            <div class="total-row">
                <span>{{ ucfirst($transaksi->metode_bayar) }}</span>
                <span>{{ format_rupiah($transaksi->bayar) }}</span>
            </div>
            <div class="total-row">
                <span>Kembali</span>
                <span>{{ format_rupiah($transaksi->kembalian) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>{{ \App\Models\Pengaturan::get('nota_pesan', 'Terima kasih telah berbelanja di SiBuku!') }}</p>
            <p style="margin-top: 10px; font-size: 10px;">{{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <!-- Button Container -->
    <div class="button-container">
        <button class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print"></i>
            <span>Cetak Nota</span>
        </button>
        
        <a href="{{ route('transaksi.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i>
            <span>Transaksi Baru</span>
        </a>
        
        <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
            <i class="fas fa-list"></i>
            <span>Kembali ke Daftar Transaksi</span>
        </a>
        
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-home"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <script>
        // Auto print saat halaman dimuat (opsional - uncomment jika ingin auto print)
        // window.onload = function() { 
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
    </script>
</body>
</html>