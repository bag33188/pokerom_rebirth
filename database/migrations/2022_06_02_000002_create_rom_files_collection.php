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
        //!! never execute. current data is intended to be permanent !!//
        if (self::ALLOW_MIGRATIONS === true) {

            Schema::connection($this->connection)->create('rom_files', function (Blueprint $collection) {
                $collection->index(['filename', 'filetype'], 'filename_1_filetype_1',
                    options: ['unique' => true, 'partialFilterExpression' =>
                        ['filename' => ['$exists' => true], 'filetype' => ['$exists' => true]]]);
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
                ->table('rom_files', function (Blueprint $collection) {
                    $collection->drop();
                });
        }
    }
};
