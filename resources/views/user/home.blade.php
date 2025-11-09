@extends('layouts.app')

@section('title', 'Home - Afikry')

@section('content')
<div class="min-h-screen">
    <!-- Banner -->
    @if($banner)
    <section class="bg-afikry-primary text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $banner->title }}</h1>
            <p class="text-xl md:text-2xl mb-8">{{ $banner->content }}</p>
            <a href="{{ route('products') }}" class="bg-white text-afikry-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                Lihat Produk
            </a>
        </div>
    </section>
    @endif

    <!-- About Section -->
    @if($about)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang Kami</h2>
                <p class="text-gray-600 text-lg leading-relaxed">{{ $about->content }}</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Produk Terbaru</h2>
            
            @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
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
                        <p class="text-afikry-primary font-bold text-lg mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <span class="inline-block px-3 py-1 text-sm rounded-full {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stok > 0 ? 'Tersedia' : 'Stok Habis' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada produk yang tersedia.</p>
            </div>
            @endif

            <div class="text-center mt-8">
                <a href="{{ route('products') }}" class="bg-afikry-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-afikry-secondary transition duration-300">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>
</div>
@endsection