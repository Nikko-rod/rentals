<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'price',
        'location',
        'type',
        'gender_restriction',
        'landmarks',
        'is_available',
        'is_verified'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_verified' => 'boolean'
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}