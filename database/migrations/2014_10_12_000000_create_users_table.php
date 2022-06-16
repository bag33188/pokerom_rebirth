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
        $user_table_password_comment = '60 chars for bcrypt hashing specification';
        Schema::create('users', function (Blueprint $table) use ($user_table_password_comment) {
            $table->id()->autoIncrement();
            $table->string('name', 45);
            $table->string('email', 35)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password', 60)->comment($user_table_password_comment);
            $table->enum('role', USER_ROLES)->default('user');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
