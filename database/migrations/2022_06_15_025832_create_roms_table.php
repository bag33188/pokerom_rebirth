<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'mysql';
    public $withinTransaction = true;
    private const TABLE_NAME = 'roms';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->char('file_id', OBJECT_ID_LENGTH)->nullable()->unique()->comment('this unique constraint references a MongoDB GridFS file database which is binded at the API level.');
            $table->bigInteger('game_id')->unsigned()->nullable()->unique();
            $table->string('rom_name', MAX_ROM_NAME)->unique();
            $table->integer('rom_size')->default(MIN_ROM_SIZE)->unsigned()->comment('rom size value measured in kilobytes');
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
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
