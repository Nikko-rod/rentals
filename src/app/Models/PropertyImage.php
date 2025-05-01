<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_path',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}