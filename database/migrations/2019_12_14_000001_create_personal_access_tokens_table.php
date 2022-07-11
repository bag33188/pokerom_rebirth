<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    protected $connection = 'mysql';
    public $withinTransaction = true;
    private const TABLE_NAME = 'personal_access_tokens';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('tokenable');
            $table->string('name', PERSONAL_ACCESS_TOKEN_NAME_LENGTH)->comment("used to be 15 in pokerom_v3, may want to look into that");
            $table->char('token', PERSONAL_ACCESS_TOKEN_LENGTH)->unique()->comment('tokenable id references user id on users table');
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
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
}
