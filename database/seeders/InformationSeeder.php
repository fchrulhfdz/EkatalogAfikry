<?php

namespace Database\Seeders;

use App\Models\Information;
use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    public function run(): void
    {
        $information = [
            [
                'title' => 'Selamat Datang di Afikry',
                'content' => 'UMKM Afikry menyediakan berbagai produk berkualitas dengan harga terjangkau. Kami berkomitmen untuk memberikan pelayanan terbaik kepada pelanggan.',
                'type' => 'banner'
            ],
            [
                'title' => 'Tentang Afikry',
                'content' => 'Afikry adalah UMKM yang bergerak di bidang penjualan berbagai produk kebutuhan sehari-hari. Didirikan pada tahun 2020, kami telah melayani ribuan pelanggan dengan produk berkualitas. Kami percaya bahwa kualitas dan kepercayaan pelanggan adalah kunci kesuksesan bisnis kami.',
                'type' => 'about'
            ],
            [
                'title' => 'Kontak Kami',
                'content' => "Alamat: Jl. Contoh No. 123, Jakarta\nTelepon: (021) 1234-5678\nEmail: info@afikry.com\nWhatsApp: 0812-3456-7890\nJam Operasional: Senin - Minggu, 08:00 - 17:00 WIB",
                'type' => 'contact'
            ]
        ];

        foreach ($information as $info) {
            Information::create($info);
        }
    }
}