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
            Schema::connection($this->connection)->create('rom_files.info', function (Blueprint $collection) {
                // compound index
                // filename and filetype fields are unique if they already exist together on the same document
                // at the time of querying
                $collection->index(
                    columns: ['filename', 'filetype'],
                    name: 'filename_1_filetype_1',
                    options: [
                        'unique' => true,
                        'partialFilterExpression' => [
                            'filename' => ['$exists' => true],
                            'filetype' => ['$exists' => true]
                        ]
                    ]
                );
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
