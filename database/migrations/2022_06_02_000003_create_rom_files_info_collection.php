<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration {

    protected $connection = 'mongodb';

    public $withinTransaction = true;

    protected static bool $_ALLOW_MIGRATIONS = false;

    private const COLLECTION_NAME = 'rom_files.info';

    private static function getFileTypeEnumValues(): array
    {
        $fileTypes = [];
        foreach (ROM_FILE_EXTENSIONS as $fileType) $fileTypes[] = str_replace('.', '', $fileType);
        return $fileTypes;
    }

    public function up(): void
    {
        if (self::$_ALLOW_MIGRATIONS === true) {
            $filename_length = MAX_ROM_FILENAME_LENGTH - 4;
            $filesize_total_digits = strlen(strval(MAX_ROM_FILE_SIZE));

            Schema::connection($this->connection)->create(self::COLLECTION_NAME, function (Blueprint $collection) use ($filename_length, $filesize_total_digits) {
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
                $collection->string('filename', $filename_length);
                $collection->enum('filetype', self::getFileTypeEnumValues());
                $collection->double('filesize', total: $filesize_total_digits, places: 0, unsigned: true);
            });
        }
    }

    public function down(): void
    {
        if (self::$_ALLOW_MIGRATIONS === true) {
            Schema::dropIfExists(self::COLLECTION_NAME);

            # Schema::connection($this->connection)
            #     ->table(self::COLLECTION_NAME, function (Blueprint $collection) {
            #         $collection->drop();
            #     });
        }
    }
};
