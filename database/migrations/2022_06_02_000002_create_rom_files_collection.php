<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration {

    protected $connection = 'mongodb';

    public $withinTransaction = true;

    private const ALLOW_MIGRATIONS = false;


    public function up(): void
    {
        if (self::ALLOW_MIGRATIONS === true) {
            Schema::connection($this->connection)->create('rom_files', function (Blueprint $collection) {
                $collection->index(['filename', 'filetype'], 'filename_1_filetype_1',
                    options: ['unique' => true, 'partialFilterExpression' =>
                        ['filename' => ['$exists' => true], 'filetype' => ['$exists' => true]]]);
            });
        }
    }

    public function down(): void
    {
        if (self::ALLOW_MIGRATIONS === true) {
            Schema::connection($this->connection)
                ->table('rom_files', function (Blueprint $collection) {
                    $collection->drop();
                });
        }
    }
};
