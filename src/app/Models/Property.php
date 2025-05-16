<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
      use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'contact_number',
        'available_for',
        'type',
        'address',
        'monthly_rent',
        'is_available'
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
        'is_available' => 'boolean',
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
    public function inquiries()
{
    return $this->hasMany(Inquiry::class);
}
public function landlord(): BelongsTo
    {
        return $this->belongsTo(Landlord::class, 'user_id', 'user_id');
    }


}