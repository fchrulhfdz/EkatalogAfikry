@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk</h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama" id="nama" value="{{ $product->nama }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary">
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="harga" id="harga" value="{{ $product->harga }}" required min="0"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary">
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ $product->stok }}" required min="0"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                              class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary">{{ $product->deskripsi }}</textarea>
                </div>

                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    @if($product->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="h-20 w-20 object-cover rounded">
                    </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                    Batal
                </a>
                <button type="submit" class="bg-afikry-primary text-white px-4 py-2 rounded-lg hover:bg-afikry-secondary transition duration-300">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection