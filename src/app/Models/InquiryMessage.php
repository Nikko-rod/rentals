<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryMessage extends Model
{
    protected $fillable = [
        'inquiry_id',
        'message',
        'is_landlord',
        'read_at'
    ];

    protected $casts = [
        'is_landlord' => 'boolean',
        'read_at' => 'datetime'
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}