<?php

namespace Database\Factories;

use App\Models\Rom;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<Rom>
 */
class RomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['rom_name' => "string", 'rom_size' => "int", 'rom_type' => "string", 'has_file' => "false", 'has_game' => "false", 'file_id' => "null"])]
    public function definition(): array
    {
        return [
            'rom_name' => strtoupper($this->faker->lastName()),
            'rom_size' => rand((MIN_FILE_SIZE / 0x400) + 1, (MAX_FILE_SIZE / 0x400) - 1),
            'rom_type' => ROM_TYPES[rand(0, sizeof(ROM_TYPES) - 1)],
            'has_file' => false,
            'has_game' => false,
            'file_id' => null
        ];
    }
}
