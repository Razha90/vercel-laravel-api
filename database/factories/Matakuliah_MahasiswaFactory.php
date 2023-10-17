<?php

namespace Database\Factories;

use App\Models\Matakuliah_Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matakuliah_Mahasiswa>
 */
class Matakuliah_MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Matakuliah_Mahasiswa::class;
    public function definition(): array
    {
        static $id = 76;
        return [
            'id' => ++$id,
            'id_matakuliah' => fake()->numberBetween(2,99),
            'id_mahasiswa' => fake()->numberBetween(2,99)
        ];
    }
}
