<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $banner = Information::where('type', 'banner')->first();
        $about = Information::where('type', 'about')->first();
        $contact = Information::where('type', 'contact')->first();

        // Statistics for dashboard
        $totalProducts = Product::count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $todayRevenue = Transaction::whereDate('created_at', today())->sum('total');

        return view('admin.information.index', compact(
            'banner', 
            'about', 
            'contact',
            'totalProducts',
            'todayTransactions',
            'todayRevenue'
        ));
    }

    public function edit(Information $information)
    {
        return view('admin.information.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $information->update($request->only(['title', 'content']));

        return redirect()->route('admin.information.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }
}