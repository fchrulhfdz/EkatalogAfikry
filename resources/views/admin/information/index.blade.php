@extends('layouts.admin')

@section('title', 'Manajemen Informasi - Afikry')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Informasi</h1>
            <p class="text-gray-600">Kelola konten website dan informasi UMKM</p>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Banner Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-images text-white text-xl"></i>
                    <h2 class="text-lg font-semibold text-white">Banner Utama</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Judul Banner</h3>
                    <p class="text-gray-600">{{ $banner->title ?? 'Belum diatur' }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2">Konten Banner</h3>
                    <p class="text-gray-600 line-clamp-3">{{ $banner->content ?? 'Belum diatur' }}</p>
                </div>
                <a href="{{ route('admin.information.edit', $banner->id ?? 1) }}" 
                   class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Banner</span>
                </a>
            </div>
        </div>

        <!-- About Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-store text-white text-xl"></i>
                    <h2 class="text-lg font-semibold text-white">Tentang Kami</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Judul Tentang</h3>
                    <p class="text-gray-600">{{ $about->title ?? 'Belum diatur' }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-600 line-clamp-3">{{ $about->content ?? 'Belum diatur' }}</p>
                </div>
                <a href="{{ route('admin.information.edit', $about->id ?? 2) }}" 
                   class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Tentang</span>
                </a>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-address-book text-white text-xl"></i>
                    <h2 class="text-lg font-semibold text-white">Kontak & Alamat</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Judul Kontak</h3>
                    <p class="text-gray-600">{{ $contact->title ?? 'Belum diatur' }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2">Informasi Kontak</h3>
                    <div class="text-gray-600 text-sm space-y-1 line-clamp-4">
                        {!! nl2br(e($contact->content ?? 'Belum diatur')) !!}
                    </div>
                </div>
                <a href="{{ route('admin.information.edit', $contact->id ?? 3) }}" 
                   class="w-full bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Kontak</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Preview Section -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Preview Website</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('home') }}" target="_blank" 
               class="border rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition duration-200 text-center">
                <i class="fas fa-home text-blue-500 text-2xl mb-2"></i>
                <h3 class="font-semibold">Halaman Home</h3>
                <p class="text-sm text-gray-600">Lihat tampilan beranda</p>
            </a>
            
            <a href="{{ route('products') }}" target="_blank" 
               class="border rounded-lg p-4 hover:border-green-500 hover:shadow-md transition duration-200 text-center">
                <i class="fas fa-box text-green-500 text-2xl mb-2"></i>
                <h3 class="font-semibold">Halaman Produk</h3>
                <p class="text-sm text-gray-600">Lihat katalog produk</p>
            </a>
            
            <a href="{{ route('information') }}" target="_blank" 
               class="border rounded-lg p-4 hover:border-purple-500 hover:shadow-md transition duration-200 text-center">
                <i class="fas fa-info-circle text-purple-500 text-2xl mb-2"></i>
                <h3 class="font-semibold">Halaman Informasi</h3>
                <p class="text-sm text-gray-600">Lihat informasi kontak</p>
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $todayTransactions }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection