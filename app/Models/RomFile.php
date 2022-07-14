<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;
use MongoDB\BSON\ObjectId;
use Utils\Classes\AbstractGridFSModel as GridFSModel;

/** @mixin GridFSModel */
class RomFile extends MongoDbModel
{

    protected $connection = 'mongodb';
    protected $collection = 'rom.files';
    protected $table = 'rom.files'; /*! don't delete!! use for eloquent helper code */
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $casts = [
        'uploadDate' => 'datetime',
    ];

    /** @var int 1024 */
    public final const DATA_BYTE_FACTOR = 0b010000000000;

    public function getObjectId(): ObjectId
    {
        return new ObjectId($this->getKey());
    }

    public function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, '_id', 'file_id');
    }

    /**
     * {@see Rom::rom_size rom_size} is represented in **kibibytes**.
     * The method return's the RomFile's {@see RomFile::length length} value
     * divided by {@see RomFile::DATA_BYTE_FACTOR `1024`} and rounds upward using
     * the {@see ceil} function (casts result as integer).
     *
     * @return int
     */
    public function calculateRomSizeFromLength(): int
    {
        return (int)ceil($this->attributes['length'] / self::DATA_BYTE_FACTOR);
    }
}
