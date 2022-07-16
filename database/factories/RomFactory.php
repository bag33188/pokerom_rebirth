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
    private static function generateRandomRomSizeValue(): int
    {
        $min = intval(MIN_ROM_FILE_SIZE / DATA_BYTE_FACTOR, 16) + 0x02;
        $max = intval(MAX_ROM_FILE_SIZE / DATA_BYTE_FACTOR, 16) - 0x02;
        return rand($min, $max);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['rom_name' => "string", 'rom_size' => "int", 'rom_type' => "string", 'has_file' => "false", 'has_game' => "false", 'file_id' => "null", 'game_id' => "null"])]
    public function definition(): array
    {
        return [
            'rom_name' => strtoupper($this->faker->lastName()),
            'rom_size' => self::generateRandomRomSizeValue(),
            'rom_type' => ROM_TYPES[rand(0, sizeof(ROM_TYPES) - 1)],
            'has_file' => FALSE,
            'has_game' => FALSE,
            'file_id' => NULL,
            'game_id' => NULL
        ];
    }
}
