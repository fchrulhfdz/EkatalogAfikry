<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::where('stok', '>', 0)->get();
        $recentTransactions = Transaction::with(['user', 'details.product'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.cashier.index', compact('products', 'recentTransactions'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0'
        ]);

        $items = $request->items;
        $total = 0;

        // Calculate total and check stock
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            if ($product->stok < $item['quantity']) {
                return response()->json([
                    'message' => "Stok {$product->nama} tidak mencukupi. Stok tersedia: {$product->stok}"
                ], 422);
            }
            $total += $product->harga * $item['quantity'];
        }

        if ($request->bayar < $total) {
            return response()->json([
                'message' => 'Jumlah bayar kurang dari total.'
            ], 422);
        }

        // Create transaction
        $transaction = Transaction::create([
            'total' => $total,
            'bayar' => $request->bayar,
            'kembali' => $request->bayar - $total,
            'user_id' => auth()->id()
        ]);

        // Create transaction details and update stock
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            $subtotal = $product->harga * $item['quantity'];

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ]);

            // Update stock
            $product->decrement('stok', $item['quantity']);
        }

        // Load relationship for response
        $transaction->load(['details.product', 'user']);

        return response()->json([
            'message' => 'Transaksi berhasil disimpan.',
            'transaction' => $transaction
        ]);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['details.product', 'user']);
        return view('admin.cashier.show', compact('transaction'));
    }

    public function print(Transaction $transaction)
    {
        $transaction->load(['details.product', 'user']);
        return view('admin.cashier.print', compact('transaction'));
    }
}