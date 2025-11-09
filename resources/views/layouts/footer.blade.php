<footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-xl font-bold mb-4">Afikry</h3>
                <p class="text-gray-300">UMKM yang menyediakan berbagai produk berkualitas dengan harga terjangkau.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-300">Home</a></li>
                    <li><a href="{{ route('products') }}" class="text-gray-300 hover:text-white transition duration-300">Produk</a></li>
                    <li><a href="{{ route('information') }}" class="text-gray-300 hover:text-white transition duration-300">Informasi</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                <div class="space-y-2 text-gray-300">
                    <p><i class="fas fa-map-marker-alt mr-2"></i> Jl. Contoh No. 123, Jakarta</p>
                    <p><i class="fas fa-phone mr-2"></i> (021) 1234-5678</p>
                    <p><i class="fas fa-envelope mr-2"></i> info@afikry.com</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} Afikry. All rights reserved.</p>
        </div>
    </div>
</footer>