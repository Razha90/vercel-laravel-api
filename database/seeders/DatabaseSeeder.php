<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dosen;
use App\Models\DosenMatakuliah;
use App\Models\DosenPembimbing;
use App\Models\mahasiswa;
use App\Models\Matakuliah;
use App\Models\Matakuliah_Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Dosen::factory(100)->create();
        // mahasiswa::factory(100)->create();
        // DosenPembimbing::factory(200) -> create();
        // Matakuliah::factory(100)->create();
        // DosenMatakuliah::factory(200)->create();
        Matakuliah_Mahasiswa::factory(200)->create();
    }
}
