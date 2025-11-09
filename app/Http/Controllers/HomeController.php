<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Information;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Information::where('type', 'banner')->first();
        $about = Information::where('type', 'about')->first();
        $products = Product::where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        return view('user.home', compact('banner', 'about', 'products'));
    }

    public function products()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('user.products', compact('products'));
    }

    public function information()
    {
        $contact = Information::where('type', 'contact')->first();
        $about = Information::where('type', 'about')->first();
        
        return view('user.information', compact('contact', 'about'));
    }
}