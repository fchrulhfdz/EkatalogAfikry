<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');

        $query = Transaction::with(['user', 'details.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Calculate summary
        $totalRevenue = $transactions->sum('total');
        $totalProductsSold = TransactionDetail::whereIn('transaction_id', $transactions->pluck('id'))
            ->sum('quantity');

        $users = User::whereIn('role', ['admin', 'cashier'])->get();

        // Export to Excel
        if ($request->export === 'excel') {
            return $this->exportExcel($transactions, $startDate, $endDate);
        }

        return view('admin.reports.index', compact(
            'transactions', 
            'totalRevenue', 
            'totalProductsSold', 
            'startDate', 
            'endDate',
            'users'
        ));
    }

    private function exportExcel($transactions, $startDate, $endDate)
    {
        // Simple CSV export
        $fileName = 'laporan-transaksi-' . $startDate . '-hingga-' . $endDate . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            fputcsv($file, ['Tanggal', 'Kode Transaksi', 'Kasir', 'Total', 'Items']);
            
            foreach ($transactions as $transaction) {
                $items = $transaction->details->map(function($detail) {
                    return $detail->product->nama . ' (' . $detail->quantity . 'x)';
                })->implode(', ');
                
                fputcsv($file, [
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->kode_transaksi,
                    $transaction->user->name,
                    'Rp ' . number_format($transaction->total, 0, ',', '.'),
                    $items
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}