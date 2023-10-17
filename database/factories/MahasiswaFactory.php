<?php

namespace Database\Factories;

use App\Models\mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = mahasiswa::class;
    public function definition(): array
    {
    static $id =0;
        return [
            'nim' => ++$id,
            'nama' => fake()->name(),
            'kontak' => fake()->randomNumber(),
            'email' => fake()->safeEmail(),
            'alamat' => fake()->address()
        ];
    }
}
