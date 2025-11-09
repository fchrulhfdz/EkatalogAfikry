<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk {{ $transaction->kode_transaksi }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier Prime', monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
            max-width: 300px;
            background: white;
        }
        
        .receipt {
            width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .company-address {
            font-size: 10px;
            margin-bottom: 3px;
        }
        
        .receipt-info {
            margin-bottom: 10px;
            padding: 5px 0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        
        .items {
            width: 100%;
            margin: 10px 0;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            padding: 2px 0;
        }
        
        .item-name {
            flex: 3;
            font-weight: bold;
        }
        
        .item-qty {
            flex: 1;
            text-align: center;
        }
        
        .item-price {
            flex: 2;
            text-align: right;
        }
        
        .item-detail {
            font-size: 10px;
            color: #666;
            margin-left: 10px;
        }
        
        .total-section {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .total-final {
            font-weight: bold;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: monospace;
            font-size: 16px;
            letter-spacing: 2px;
        }
        
        .separator {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 5px;
                font-size: 11px;
            }
            
            .no-print {
                display: none !important;
            }
            
            .receipt {
                width: 280px;
            }
            
            @page {
                margin: 0;
                size: auto;
            }
        }
        
        /* Screen Styles */
        @media screen {
            body {
                background: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            
            .receipt {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            .print-btn {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #3B82F6;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-family: Arial, sans-serif;
                z-index: 1000;
            }
            
            .print-btn:hover {
                background: #2563EB;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button (Hanya tampil di browser) -->
    <button class="print-btn no-print" onclick="window.print()">
        🖨️ Cetak Struk
    </button>

    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="company-name">AFIKRY STORE</div>
            <div class="company-address">Jl. Contoh No. 123, Jakarta</div>
            <div class="company-address">Telp: (021) 1234-5678</div>
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="info-row">
                <span>Struk:</span>
                <span><strong>{{ $transaction->kode_transaksi }}</strong></span>
            </div>
            <div class="info-row">
                <span>Tanggal:</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Kasir:</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
        </div>
        
        <div class="separator"></div>
        
        <!-- Items -->
        <div class="items">
            @foreach($transaction->details as $detail)
            <div class="item-row">
                <div class="item-name">{{ $detail->product->nama }}</div>
                <div class="item-qty">{{ $detail->quantity }}x</div>
                <div class="item-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
            </div>
            <div class="item-row">
                <div class="item-detail">@ Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</div>
                <div class="item-qty"></div>
                <div class="item-price"></div>
            </div>
            @endforeach
        </div>
        
        <div class="separator"></div>
        
        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row total-final">
                <span>KEMBALI:</span>
                <span>Rp {{ number_format($transaction->kembali, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Barcode -->
        <div class="barcode">
            {{ $transaction->kode_transaksi }}
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div>Terima kasih atas kunjungan Anda</div>
            <div>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</div>
            <div>www.afikry.com</div>
        </div>
    </div>

    <script>
        // Auto print ketika halaman load (opsional)
        window.onload = function() {
            // Tunggu sebentar agar konten terload sempurna
            setTimeout(() => {
                // Uncomment baris berikut untuk auto print
                // window.print();
            }, 500);
        };

        // Handle setelah print
        window.onafterprint = function() {
            // Kembali ke halaman kasir setelah print (opsional)
            // setTimeout(() => {
            //     window.close(); // Tutup window/tab
            // }, 1000);
        };

        // Keyboard shortcut untuk print (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>