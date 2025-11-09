@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-box text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Produk</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Stok Menipis</p>
                <p class="text-2xl font-bold text-gray-900">{{ $lowStockProducts }}</p>
            </div>
        </div>
    </div>

    <!-- Today Transactions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ $todayTransactions }}</p>
            </div>
        </div>
    </div>

    <!-- Today Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-lg font-semibold mb-4">Transaksi Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Kode Transaksi</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Kasir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $transaction)
                <tr class="border-t">
                    <td class="px-4 py-3 text-sm">{{ $transaction->kode_transaksi }}</td>
                    <td class="px-4 py-3 text-sm">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-sm">{{ $transaction->user->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada transaksi hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection