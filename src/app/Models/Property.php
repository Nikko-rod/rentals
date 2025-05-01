<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'contact_number',
        'available_for',
        'type',
        'address',
        'monthly_rent',
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}