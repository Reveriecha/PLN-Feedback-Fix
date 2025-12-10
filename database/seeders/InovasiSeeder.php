<?php

namespace Database\Seeders;

use App\Models\Inovasi;
use Illuminate\Database\Seeder;

class InovasiSeeder extends Seeder
{
    public function run()
    {
        $inovasis = [
            [
                'nama_inovasi' => 'PolyPurple Email Subscription',
                'deskripsi' => 'Sistem subscription email otomatis',
            ],
            [
                'nama_inovasi' => 'PolyPurple Contact Form',
                'deskripsi' => 'Form kontak terintegrasi',
            ],
            [
                'nama_inovasi' => 'Hashtag Ocean Signups',
                'deskripsi' => 'Sistem pendaftaran berbasis hashtag',
            ],
            [
                'nama_inovasi' => 'PolyPurple Enquiry Form',
                'deskripsi' => 'Form pertanyaan pelanggan',
            ],
            [
                'nama_inovasi' => 'FormsOcean Email Subscription',
                'deskripsi' => 'Subscription email FormsOcean',
            ],
        ];
        
        foreach ($inovasis as $inovasi) {
            Inovasi::create($inovasi + ['is_active' => true]);
        }
    }
}