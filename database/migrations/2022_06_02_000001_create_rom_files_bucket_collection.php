<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration {

    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Execute migration within transaction IF AVAILABLE
     *
     * @var bool
     */
    public $withinTransaction = true;

    // don't allow migrations
    private const ALLOW_MIGRATIONS = false;


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        /*!! never execute. current data is intended to be permanent !!*/
        if (self::ALLOW_MIGRATIONS === true) {
            Schema::connection($this->connection)->create('rom.files', function (Blueprint $collection) {
                $collection->index(
                    columns: ['length', 'filename'],
                    name: 'length_1_filename_1',
                    options: [
                        'unique' => true,
                        'partialFilterExpression' => [
                            'filename' => ['$exists' => true]
                        ]
                    ]
                );
            });
            Schema::connection($this->connection)->create('rom.chunks', function (Blueprint $collection) {
                $collection->index(
                    columns: ['files_id', 'n'],
                    name: 'files_id_1_n_1',
                    options: ['unique' => true]
                );
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        /*! don't use down methods as it could overwrite current files in db */
        if (self::ALLOW_MIGRATIONS === true) {
            Schema::connection($this->connection)
                ->table('rom.files', function (Blueprint $collection) {
                    $collection->drop();
                });
            Schema::connection($this->connection)
                ->table('rom.chunks', function (Blueprint $collection) {
                    $collection->drop();
                });
        }
    }
};
