<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;
use MongoDB\BSON\ObjectId;
use Utils\Classes\_Abstract\AbstractGridFSModel as GridFSModel;
use Utils\Classes\_Static\MongoMethods as MongoUtil;

/** @mixin GridFSModel */
class RomFile extends MongoDbModel
{
    protected $connection = 'mongodb';
    protected $collection = 'rom.files';
    protected $table = 'rom.files'; //! don't delete!! use for eloquent helper code
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $casts = [
        'uploadDate' => 'datetime',
    ];

    public function getObjectId(): ObjectId
    {
        return MongoUtil::parseStringAsBSONObjectId($this->getKey());
    }

    public function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, '_id', 'file_id');
    }
}
