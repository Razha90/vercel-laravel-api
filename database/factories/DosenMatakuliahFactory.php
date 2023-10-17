<?php

namespace Database\Factories;

use App\Models\DosenMatakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DosenMatakuliah>
 */
class DosenMatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DosenMatakuliah::class;
    public function definition(): array
    {
        static $id = 0;
        return [
            'id' => ++$id,
            'id_dosen' => fake()->numberBetween(1,100),
            'id_matakuliah' => fake()->numberBetween(1, 100)
        ];
    }
}
