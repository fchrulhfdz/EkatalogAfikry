@extends('layouts.app')

@section('title', 'Produk - Afikry')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Daftar Produk</h1>

        <!-- Filter & Search -->
        <div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="w-full md:w-auto">
                <input type="text" placeholder="Cari produk..." class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-afikry-primary focus:border-transparent">
            </div>
            <div class="flex space-x-2">
                <button class="bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">Semua</button>
                <button class="bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">Tersedia</button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->nama }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->deskripsi }}</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-afikry-primary">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->status }}
                        </span>
                    </div>
                    
                    <div class="text-sm text-gray-500">
                        Stok: {{ $product->stok }} pcs
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($products->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Tidak ada produk yang tersedia saat ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection