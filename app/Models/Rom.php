<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Jenssegers\Mongodb\Eloquent\Builder as QueryBuilder;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Relations\HasOne as HasOneDocument;

class Rom extends Model
{
    use HasFactory, HybridRelations;

    protected $connection = 'mysql';
    protected $table = 'roms';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = ['rom_name', 'rom_size', 'rom_type'];
    protected $guarded = ['file_id', 'game_id', 'has_game', 'has_file'];
    protected $attributes = [
        'rom_size' => 1020,
        'has_file' => false,
        'has_game' => false
    ];
    protected $casts = [
        'has_file' => 'bool',
        'has_game' => 'bool',
    ];

    public function getRomFileName(): string
    {
        return sprintf("%s.%s", $this->rom_name, strtolower($this->rom_type));
    }

    public final function game(): HasOne
    {
        return $this->hasOne(Game::class, 'rom_id', 'id');
    }

    public final function file(): HasOneDocument
    {
        return $this->hasOne(File::class, '_id', 'file_id');
    }

    protected final function romType(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value)
        );
    }

    public function setRomTypeAttribute(string $value): void
    {
        $this->attributes['rom_type'] = strtolower($value);
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     * @return QueryBuilder|null
     */
    public function searchForFileMatchingRom(): QueryBuilder|null
    {
        return File::where('filename', '=', $this->getRomFileName());
    }
}
