<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            'Unit Induk Pembangunan',
            'Unit Induk Transmisi',
            'Unit Induk Distribusi',
            'Unit Pelaksana Pelayanan Pelanggan',
        ];
        
        foreach ($units as $unit) {
            Unit::create(['nama_unit' => $unit]);
        }
    }
}