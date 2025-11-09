<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-afikry-primary">Afikry</a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-afikry-primary font-medium {{ request()->routeIs('home') ? 'text-afikry-primary' : '' }}">Home</a>
                <a href="{{ route('products') }}" class="text-gray-700 hover:text-afikry-primary font-medium {{ request()->routeIs('products') ? 'text-afikry-primary' : '' }}">Produk</a>
                <a href="{{ route('information') }}" class="text-gray-700 hover:text-afikry-primary font-medium {{ request()->routeIs('information') ? 'text-afikry-primary' : '' }}">Informasi</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-afikry-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-afikry-secondary transition duration-300">
                        Admin Panel
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-700 hover:text-afikry-primary focus:outline-none focus:text-afikry-primary">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</nav>