<?php

namespace Database\Seeders;

use App\Models\Rom;
use Illuminate\Database\Seeder;

class RomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Rom::factory()->count(2)->create();
    }
}
