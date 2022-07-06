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
        Schema::create('sessions', function (Blueprint $table) {
            $table->char('id', SESSION_ID_LENGTH)->primary();
            $table->foreignId('user_id')->nullable()->index()
                ->references('id')->on('users')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->string('ip_address', IP_ADDRESS_LENGTH)->nullable()->comment("45 characters because of ipv6");
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
