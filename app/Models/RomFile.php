<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;
use MongoDB\BSON\ObjectId;
use Utils\Classes\AbstractGridFsFile as GfsFile;
use Utils\Modules\GridFsMethods;

/** @mixin GfsFile */
class RomFile extends MongoDbModel
{
    protected $connection = 'mongodb';
    protected $collection = 'roms.files';
    protected $table = 'roms.files'; //! don't delete!! use for eloquent helper code
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $casts = [
        'uploadDate' => 'datetime',
    ];

    public function getObjectId(): ObjectId
    {
        return GridFsMethods::parseObjectId($this->getKey());
    }

    public final function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, '_id', 'file_id');
    }
}
