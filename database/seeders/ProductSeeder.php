<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Kopi Arabica Gayo',
                'harga' => 75000,
                'deskripsi' => 'Kopi arabica asal Gayo dengan aroma yang harum dan rasa yang khas. Dipetik dan diproses secara tradisional untuk menjaga cita rasa asli.',
                'stok' => 50,
                'gambar' => null
            ],
            [
                'nama' => 'Kopi Robusta Lampung',
                'harga' => 60000,
                'deskripsi' => 'Kopi robusta dengan cita rasa kuat dan aroma yang khas. Perfect untuk pecinta kopi dengan rasa yang bold.',
                'stok' => 30,
                'gambar' => null
            ],
            [
                'nama' => 'Teh Hijau Organik',
                'harga' => 45000,
                'deskripsi' => 'Teh hijau organik dengan antioksidan tinggi. Dipetik dari kebun teh organik yang bebas pestisida.',
                'stok' => 25,
                'gambar' => null
            ],
            [
                'nama' => 'Madu Hutan Asli',
                'harga' => 120000,
                'deskripsi' => 'Madu hutan murni yang diambil langsung dari hutan alam. Kaya akan nutrisi dan khasiat alami.',
                'stok' => 15,
                'gambar' => null
            ],
            [
                'nama' => 'Gula Aren Organik',
                'harga' => 35000,
                'deskripsi' => 'Gula aren organik dengan rasa manis alami. Cocok untuk berbagai macam minuman dan masakan.',
                'stok' => 40,
                'gambar' => null
            ],
            [
                'nama' => 'Keripik Singkong Balado',
                'harga' => 25000,
                'deskripsi' => 'Keripik singkong dengan bumbu balado yang pedas dan gurih. Renyah dan nikmat sebagai camilan.',
                'stok' => 60,
                'gambar' => null
            ],
            [
                'nama' => 'Dodol Garut Original',
                'harga' => 40000,
                'deskripsi' => 'Dodol khas Garut dengan tekstur kenyal dan rasa manis yang pas. Dibuat dengan resep tradisional.',
                'stok' => 20,
                'gambar' => null
            ],
            [
                'nama' => 'Minyak Kelapa Murni',
                'harga' => 55000,
                'deskripsi' => 'Minyak kelapa murni (VCO) yang baik untuk kesehatan dan kecantikan. Diproses secara tradisional.',
                'stok' => 35,
                'gambar' => null
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}