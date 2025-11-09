@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Afikry')

@section('content')
<div class="p-6" x-data="reportApp()">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Transaksi</h1>
            <p class="text-gray-600">Analisis dan ringkasan transaksi harian</p>
        </div>
        <div class="flex space-x-3">
            <button @click="exportToExcel()" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-300 flex items-center space-x-2">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel</span>
            </button>
            <button @click="printReport()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Print</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Filter Laporan</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" x-model="filters.startDate" 
                       class="w-full border rounded-lg px-3 py-2 focus:border-afikry-primary focus:ring focus:ring-afikry-primary focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" x-model="filters.endDate" 
                       class="w-full border rounded-lg px-3 py-2 focus:border-afikry-primary focus:ring focus:ring-afikry-primary focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kasir</label>
                <select x-model="filters.userId" 
                        class="w-full border rounded-lg px-3 py-2 focus:border-afikry-primary focus:ring focus:ring-afikry-primary focus:ring-opacity-50">
                    <option value="">Semua Kasir</option>
                    <template x-for="user in users" :key="user.id">
                        <option :value="user.id" x-text="user.name"></option>
                    </template>
                </select>
            </div>
            <div class="flex items-end">
                <button @click="applyFilters()" 
                        class="w-full bg-afikry-primary text-white py-2 rounded-lg font-semibold hover:bg-afikry-secondary transition duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-filter"></i>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-receipt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="summary.total_transactions"></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="`Rp ${formatCurrency(summary.total_revenue)}`"></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Produk Terjual</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="summary.total_products_sold"></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rata-rata Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="`Rp ${formatCurrency(summary.average_transaction)}`"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Detail Transaksi</h2>
            <p class="text-sm text-gray-600" x-text="`Menampilkan ${transactions.length} transaksi`"></p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="transaction in transactions" :key="transaction.id">
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="formatDate(transaction.created_at)"></div>
                                <div class="text-sm text-gray-500" x-text="formatTime(transaction.created_at)"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900" x-text="transaction.kode_transaksi"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="transaction.user.name"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <template x-for="detail in transaction.details" :key="detail.id">
                                        <div class="flex justify-between space-x-4">
                                            <span x-text="`${detail.product.nama}`"></span>
                                            <span x-text="`${detail.quantity}x`" class="text-gray-500"></span>
                                        </div>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-semibold text-afikry-primary" 
                                     x-text="`Rp ${formatCurrency(transaction.total)}`"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a :href="`/admin/cashier/${transaction.id}`" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a :href="`/admin/cashier/${transaction.id}/print`" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-900 transition duration-200">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <tr x-show="transactions.length === 0">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p>Tidak ada data transaksi</p>
                            <p class="text-sm">Ubah filter tanggal untuk melihat data</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200" x-show="transactions.length > 0">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Menampilkan <span x-text="transactions.length"></span> transaksi
                </div>
                <div class="flex space-x-2">
                    <button @click="previousPage()" 
                            :disabled="currentPage === 1"
                            class="px-3 py-1 border rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="nextPage()" 
                            :disabled="transactions.length < perPage"
                            class="px-3 py-1 border rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function reportApp() {
    return {
        transactions: @json($transactions),
        users: @json($users),
        filters: {
            startDate: '{{ $startDate }}',
            endDate: '{{ $endDate }}',
            userId: ''
        },
        summary: {
            total_transactions: {{ $totalRevenue > 0 ? $transactions->count() : 0 }},
            total_revenue: {{ $totalRevenue }},
            total_products_sold: {{ $totalProductsSold }},
            average_transaction: {{ $totalRevenue > 0 ? $totalRevenue / $transactions->count() : 0 }}
        },
        currentPage: 1,
        perPage: 10,
        
        formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        },
        
        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        
        formatTime(dateString) {
            return new Date(dateString).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        async applyFilters() {
            try {
                const params = new URLSearchParams();
                if (this.filters.startDate) params.append('start_date', this.filters.startDate);
                if (this.filters.endDate) params.append('end_date', this.filters.endDate);
                if (this.filters.userId) params.append('user_id', this.filters.userId);
                
                window.location.href = `/admin/reports?${params.toString()}`;
            } catch (error) {
                console.error('Error applying filters:', error);
            }
        },
        
        exportToExcel() {
            // Simple Excel export simulation
            const params = new URLSearchParams();
            if (this.filters.startDate) params.append('start_date', this.filters.startDate);
            if (this.filters.endDate) params.append('end_date', this.filters.endDate);
            if (this.filters.userId) params.append('user_id', this.filters.userId);
            params.append('export', 'excel');
            
            window.location.href = `/admin/reports?${params.toString()}`;
        },
        
        printReport() {
            window.print();
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        
        nextPage() {
            if (this.transactions.length === this.perPage) {
                this.currentPage++;
            }
        }
    }
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 12px;
    }
    
    .bg-gray-50 {
        background-color: #f9fafb !important;
    }
}
</style>
@endsection