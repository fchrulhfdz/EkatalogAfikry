@extends('layouts.admin')

@section('title', 'Detail Transaksi - Afikry')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
            <p class="text-gray-600">{{ $transaction->kode_transaksi }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.cashier.print', $transaction) }}" 
               target="_blank"
               class="bg-afikry-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-afikry-secondary transition duration-300 flex items-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Cetak Ulang</span>
            </a>
            <a href="{{ route('admin.cashier.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Transaction Details -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Transaksi</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Kode Transaksi:</span>
                    <span class="font-semibold">{{ $transaction->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal:</span>
                    <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kasir:</span>
                    <span>{{ $transaction->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Selesai</span>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Belanja:</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah Bayar:</span>
                    <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <span class="text-lg font-semibold">Kembalian:</span>
                    <span class="text-lg font-bold text-green-600">Rp {{ number_format($transaction->kembali, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Items List -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Produk</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Harga</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Qty</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->details as $detail)
                    <tr class="border-t">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $detail->product->nama }}</div>
                        </td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">{{ $detail->quantity }}</td>
                        <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-semibold">Total:</td>
                        <td class="px-4 py-3 text-right font-bold text-afikry-primary text-lg">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection