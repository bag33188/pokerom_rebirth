<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql';
    public $withinTransaction = true;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db_slug_comment = 'only the slug is a unique key. since the game name can be remotely similar through novelty character encodings.';
        Schema::create('games', function (Blueprint $table) use ($db_slug_comment) {
            $table->id()->autoIncrement();
            $table->foreignId('rom_id')->unique()
                ->references('id')->on('roms')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('game_name', MAX_GAME_NAME);
            $table->enum('game_type', GAME_TYPES);
            $table->date('date_released');
            $table->tinyInteger('generation')->unsigned();
            $table->enum('region', REGIONS);
            $table->string('slug', MAX_GAME_NAME + 2)->nullable()->unique()->comment($db_slug_comment);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
