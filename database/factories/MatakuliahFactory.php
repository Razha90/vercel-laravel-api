<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matakuliah>
 */
class MatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Matakuliah::class;
    public function definition(): array
    {
        static $id = 0;
        return [
            'kode' => ++$id,
            'nama_matakuliah' => fake()->word(),
            'daya_tampung' => fake()->numberBetween(25,35),
            'jadwal' => fake()->dateTimeBetween('2023-01-01 00:00:00', '2023-12-31 23:59:59'),
        ];
    }
}
