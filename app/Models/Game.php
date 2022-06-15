<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "games";
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'game_name',
        'game_type',
        'generation',
        'date_released',
        'region',
        'rom_id' // <- fillable since the foreign key is a constraint, will throw error
    ];
    protected $casts = [
        'date_released' => 'date'
    ];

    // rom_id foreign key is NOT nullable
    public function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class, 'rom_id', 'id');
    }

    protected function gameName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_replace('Pokemon', 'Pok' . _EACUTE . 'mon', $value)
        );
    }

    protected final function region(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value)
        );
    }

    protected final function gameType(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_capitalize($value, true, 2, '-')
        );
    }

    public function setRegionAttribute(string $value): void
    {
        $this->attributes['region'] = strtolower($value);
    }

    public function setGameTypeAttribute(string $value): void
    {
        $this->attributes['game_type'] = strtolower($value);
    }
}