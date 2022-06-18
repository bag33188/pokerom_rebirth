<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'mysql';
    public $withinTransaction = true;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $db_file_id_comment = 'this unique constraint references a MongoDB GridFS file database which is binded at the API level.';
        $db_rom_size_comment = 'rom size value measured in kilobytes';

        Schema::create('roms', function (Blueprint $table) use ($db_file_id_comment, $db_rom_size_comment) {
            $table->id()->autoIncrement();
            $table->char('file_id', 24)->nullable()->unique()->comment($db_file_id_comment);
            $table->bigInteger('game_id')->unsigned()->nullable()->unique();
            $table->string('rom_name', MAX_ROM_NAME)->unique();
            $table->integer('rom_size')->default(1020)->unsigned()->comment($db_rom_size_comment);
            $table->enum('rom_type', ROM_TYPES);
            $table->boolean('has_game')->default(false);
            $table->boolean('has_file')->default(false);
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
        Schema::dropIfExists('roms');
    }
};
