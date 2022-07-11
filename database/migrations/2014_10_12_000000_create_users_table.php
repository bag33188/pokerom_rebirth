<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'mysql';
    public $withinTransaction = true;
    private const TABLE_NAME = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $userRoleIndex = array_search('user', USER_ROLES, true);
        Schema::create(self::TABLE_NAME, function (Blueprint $table) use ($userRoleIndex) {
            $table->id()->autoIncrement();
            $table->string('name', MAX_USER_NAME);
            $table->string('email', MAX_USER_EMAIL)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password', BCRYPT_PASSWORD_LENGTH)->comment('60 chars for bcrypt hashing specification');
            $table->enum('role', USER_ROLES)->default(USER_ROLES[$userRoleIndex]);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', PROFILE_PHOTO_URI_LENGTH)->nullable();
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
