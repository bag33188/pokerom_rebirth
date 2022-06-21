<?php

namespace App\Models;

use Classes\RomFile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as DocumentModel;

/** @mixin RomFile */
class File extends DocumentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'roms.files';
    protected $table = 'roms.files'; // use for eloquent helper code
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $casts = [
        'uploadDate' => 'datetime',
    ];

    public final function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, '_id', 'file_id');
    }
}
