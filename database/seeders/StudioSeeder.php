<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Studio::create([
        'nama' => 'Studio A',
        'deskripsi' => 'Studio profesional dengan lighting lengkap',
        'harga_per_jam' => 250000
    ]);
    
    Studio::create([
        'nama' => 'Studio B',
        'deskripsi' => 'Studio minimalis dengan backdrop variatif',
        'harga_per_jam' => 180000
    ]);
}
}
