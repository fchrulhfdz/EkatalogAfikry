@extends('layouts.app')

@section('title', 'Informasi - Afikry')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Informasi Afikry</h1>

        <!-- About Section -->
        @if($about)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tentang Kami</h2>
            <div class="prose max-w-none text-gray-600">
                {!! nl2br(e($about->content)) !!}
            </div>
        </div>
        @endif

        <!-- Contact Section -->
        @if($contact)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Kontak & Lokasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-afikry-primary mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Alamat</h3>
                            <p class="text-gray-600">{!! nl2br(e($contact->content)) !!}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-phone text-afikry-primary mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Telepon</h3>
                            <p class="text-gray-600">(021) 1234-5678</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-afikry-primary mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Email</h3>
                            <p class="text-gray-600">info@afikry.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                    <div class="text-center text-gray-500 p-8">
                        <i class="fas fa-map text-4xl mb-4"></i>
                        <p>Peta Lokasi</p>
                        <p class="text-sm">(Integrasikan dengan Google Maps)</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection