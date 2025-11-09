@extends('layouts.admin')

@section('title', 'Kasir - Afikry')

@section('content')
<div x-data="cashierApp()" class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kasir</h1>
            <p class="text-gray-600">Sistem Point of Sale Afikry</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-600" x-text="new Date().toLocaleString('id-ID')"></p>
            <p class="text-sm font-semibold text-afikry-primary">{{ auth()->user()->name }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Product List -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Daftar Produk</h2>
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..." 
                               class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-afikry-primary focus:border-transparent"
                               x-model="searchQuery">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div class="border rounded-lg p-4 cursor-pointer hover:border-afikry-primary hover:shadow-md transition duration-200"
                             @click="addToCart(product)">
                            <h3 class="font-semibold text-sm mb-2" x-text="product.nama"></h3>
                            <p class="text-afikry-primary font-bold text-lg mb-1" 
                               x-text="`Rp ${formatCurrency(product.harga)}`"></p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500" 
                                      x-text="`Stok: ${product.stok}`"></span>
                                <span class="text-xs px-2 py-1 rounded-full" 
                                      :class="product.stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                      x-text="product.stok > 0 ? 'Tersedia' : 'Habis'"></span>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="filteredProducts.length === 0" class="text-center py-8">
                    <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Tidak ada produk yang ditemukan</p>
                </div>
            </div>
        </div>

        <!-- Cart & Payment -->
        <div class="space-y-6">
            <!-- Cart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Keranjang Belanja</h2>
                
                <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    <div x-show="cart.length === 0" class="text-center text-gray-500 py-8">
                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-3"></i>
                        <p>Keranjang kosong</p>
                        <p class="text-sm">Klik produk untuk menambahkan</p>
                    </div>
                    
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm" x-text="item.nama"></h4>
                                <p class="text-afikry-primary font-bold text-sm" 
                                   x-text="`Rp ${formatCurrency(item.harga)}`"></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="decrementQuantity(index)" 
                                        class="bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-300 transition duration-200">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span x-text="item.quantity" class="w-8 text-center font-semibold"></span>
                                <button @click="incrementQuantity(index)" 
                                        :disabled="item.quantity >= item.stok"
                                        class="bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-300 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button @click="removeFromCart(index)" 
                                        class="text-red-500 hover:text-red-700 ml-2 transition duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Total -->
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold">Subtotal:</span>
                        <span x-text="`Rp ${formatCurrency(total)}`" class="font-semibold"></span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold">Total:</span>
                        <span x-text="`Rp ${formatCurrency(total)}`" class="text-xl font-bold text-afikry-primary"></span>
                    </div>

                    <!-- Payment Input -->
                    <div class="space-y-3" x-show="!showPaymentSuccess">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" x-model="bayar" 
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-afikry-primary focus:border-transparent text-lg font-semibold"
                                       placeholder="0"
                                       @keyup.enter="processPayment">
                            </div>
                        </div>
                        
                        <div x-show="bayar > 0">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold">Kembalian:</span>
                                <span x-text="`Rp ${formatCurrency(kembali)}`" 
                                      class="text-lg font-bold" 
                                      :class="kembali < 0 ? 'text-red-600' : 'text-green-600'"></span>
                            </div>
                        </div>

                        <button @click="processPayment" 
                                :disabled="cart.length === 0 || bayar < total || kembali < 0"
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                            <i class="fas fa-credit-card"></i>
                            <span>Proses Pembayaran</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Transaksi Terakhir</h2>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    <template x-for="transaction in recentTransactions" :key="transaction.id">
                        <div class="border rounded-lg p-3 hover:bg-gray-50 transition duration-200">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-sm" x-text="transaction.kode_transaksi"></span>
                                <span class="text-xs text-gray-500" x-text="formatTime(transaction.created_at)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-afikry-primary font-bold text-sm" 
                                      x-text="`Rp ${formatCurrency(transaction.total)}`"></span>
                                <div class="flex space-x-1">
                                    <a :href="`/admin/cashier/${transaction.id}`" 
                                       class="text-blue-600 hover:text-blue-800 text-xs">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a :href="`/admin/cashier/${transaction.id}/print`" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-800 text-xs">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="recentTransactions.length === 0" class="text-center text-gray-500 py-4">
                        <p class="text-sm">Belum ada transaksi hari ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-show="showPaymentSuccess" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <!-- Modal Header -->
            <div class="bg-green-500 text-white p-6 rounded-t-lg text-center">
                <i class="fas fa-check-circle text-5xl mb-4"></i>
                <h3 class="text-2xl font-bold">Pembayaran Berhasil!</h3>
                <p class="text-green-100 mt-2" x-text="`Kode Transaksi: ${lastTransaction.kode_transaksi}`"></p>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Transaction Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-gray-700">Total Pembayaran:</span>
                            <span class="text-lg font-bold text-afikry-primary" 
                                  x-text="`Rp ${formatCurrency(lastTransaction.total)}`"></span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-gray-700">Jumlah Bayar:</span>
                            <span class="text-gray-600" 
                                  x-text="`Rp ${formatCurrency(lastTransaction.bayar)}`"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Kembalian:</span>
                            <span class="text-green-600 font-bold" 
                                  x-text="`Rp ${formatCurrency(lastTransaction.kembali)}`"></span>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="max-h-40 overflow-y-auto">
                        <h4 class="font-semibold text-gray-800 mb-2">Items yang dibeli:</h4>
                        <div class="space-y-2">
                            <template x-for="detail in lastTransaction.details" :key="detail.id">
                                <div class="flex justify-between items-center text-sm">
                                    <span x-text="`${detail.product.nama} (${detail.quantity}x)`"></span>
                                    <span class="text-afikry-primary font-semibold" 
                                          x-text="`Rp ${formatCurrency(detail.subtotal)}`"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer - TOMBOL DISAMPING -->
<div class="p-6 border-t border-gray-200 grid grid-cols-2 gap-3">
    <!-- Tombol Kembali -->
    <button @click="newTransaction"
            class="bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 flex items-center justify-center space-x-2">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Kasir</span>
    </button>
    
    <!-- Tombol Cetak Struk -->
    <a :href="`/admin/cashier/${lastTransaction.id}/print`" 
       target="_blank"
       class="bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 flex items-center justify-center space-x-2">
        <i class="fas fa-print"></i>
        <span>Cetak Struk</span>
    </a>
</div>
        </div>
    </div>
</div>

<script>
function cashierApp() {
    return {
        cart: [],
        bayar: 0,
        searchQuery: '',
        showPaymentSuccess: false,
        lastTransaction: {},
        recentTransactions: @json($recentTransactions),
        products: @json($products),
        
        get filteredProducts() {
            if (!this.searchQuery) {
                return this.products;
            }
            return this.products.filter(product => 
                product.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        
        addToCart(product) {
            if (product.stok === 0) return;
            
            const existingItem = this.cart.find(item => item.id === product.id);
            
            if (existingItem) {
                if (existingItem.quantity < product.stok) {
                    existingItem.quantity++;
                }
            } else {
                this.cart.push({
                    ...product,
                    quantity: 1
                });
            }
        },
        
        removeFromCart(index) {
            this.cart.splice(index, 1);
        },
        
        incrementQuantity(index) {
            if (this.cart[index].quantity < this.cart[index].stok) {
                this.cart[index].quantity++;
            }
        },
        
        decrementQuantity(index) {
            if (this.cart[index].quantity > 1) {
                this.cart[index].quantity--;
            } else {
                this.removeFromCart(index);
            }
        },
        
        formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        },
        
        formatTime(dateString) {
            return new Date(dateString).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        async processPayment() {
            if (this.cart.length === 0 || this.bayar < this.total || this.kembali < 0) {
                return;
            }
            
            try {
                // Get CSRF token dengan method yang aman
                const csrfToken = this.getCsrfToken();
                
                if (!csrfToken) {
                    alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                    return;
                }
                
                const response = await fetch('/admin/cashier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        items: this.cart,
                        bayar: this.bayar
                    })
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.lastTransaction = result.transaction;
                    this.showPaymentSuccess = true;
                    this.recentTransactions.unshift(result.transaction);
                    
                    // Update product stocks
                    this.updateProductStocks();
                    
                } else {
                    alert(result.message || 'Terjadi kesalahan saat memproses pembayaran');
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        },
        
        getCsrfToken() {
            // Coba dari meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }
            
            // Coba dari input hidden
            const inputToken = document.querySelector('input[name="_token"]');
            if (inputToken) {
                return inputToken.value;
            }
            
            console.error('CSRF token tidak ditemukan');
            return null;
        },
        
        updateProductStocks() {
            this.cart.forEach(cartItem => {
                const product = this.products.find(p => p.id === cartItem.id);
                if (product) {
                    product.stok -= cartItem.quantity;
                }
            });
        },
        
        newTransaction() {
            this.cart = [];
            this.bayar = 0;
            this.showPaymentSuccess = false;
            this.lastTransaction = {};
        },
        
        get total() {
            return this.cart.reduce((sum, item) => sum + (item.harga * item.quantity), 0);
        },
        
        get kembali() {
            return this.bayar - this.total;
        }
    }
}
</script>

<style>
/* Custom scrollbar untuk modal */
.max-h-40::-webkit-scrollbar {
    width: 6px;
}

.max-h-40::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.max-h-40::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.max-h-40::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection