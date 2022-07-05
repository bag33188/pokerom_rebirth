<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;
use MongoDB\BSON\ObjectId;
use Utils\Classes\AbstractGridFSFile as GfsFile;
use Utils\Modules\MongoMethods;

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
        return MongoMethods::parseObjectId($this->getKey());
    }

    public final function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, '_id', 'file_id');
    }

    public final function getDownloadUrl(): string
    {
        $baseUrl = "/public/api";
        $baseFilesEndpoint = "rom-files/grid/{$this->getKey()}/download";
        if (App::isLocal()) return "$baseUrl/dev/$baseFilesEndpoint";
        return "$baseUrl/$baseFilesEndpoint";
    }
}
