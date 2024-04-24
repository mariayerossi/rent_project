<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //Mobil
        DB::table('mobil')->insert([
            'nama_mobil' => "Hiace Commuter",
            'foto_mobil'=>"commuter.png",
            'harga_mobil' => 100000,
            'status_mobil' => "Aktif",
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('mobil')->insert([
            'nama_mobil' => "Hiace Premio",
            'foto_mobil'=>"premio.png",
            'harga_mobil' => 200000,
            'status_mobil' => "Aktif",
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
