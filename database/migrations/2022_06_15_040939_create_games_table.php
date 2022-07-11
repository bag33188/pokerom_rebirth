<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'mysql';
    public $withinTransaction = true;
    private const TABLE_NAME = 'games';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $game_slug_length = MAX_GAME_NAME + 2;
        Schema::create(self::TABLE_NAME, function (Blueprint $table) use ($game_slug_length) {
            $table->id()->autoIncrement();
            $table->foreignId('rom_id')->unique()
                ->references('id')->on('roms')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('game_name', MAX_GAME_NAME);
            $table->enum('game_type', GAME_TYPES);
            $table->date('date_released');
            $table->tinyInteger('generation')->unsigned();
            $table->enum('region', REGIONS);
            $table->string('slug', $game_slug_length)->nullable()->unique()->comment('only the slug is a unique key. since the game name can be remotely similar through novelty character encodings.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
