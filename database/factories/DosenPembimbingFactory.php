<?php

namespace Database\Factories;

use App\Models\DosenPembimbing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DosenPembimbing>
 */
class DosenPembimbingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DosenPembimbing::class;
    public function definition(): array
    {
        static $id = 0;
        return [
            'id' => ++$id,
            'id_dosen' => fake()->randomNumber(1,100),
            'id_mahasiswa' => fake()->randomNumber(1,100)
        ];
    }
}
