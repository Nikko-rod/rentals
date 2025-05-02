<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'tenant_id',
        'landlord_id',
        'property_id',
        'quoted_monthly_rent',
        'quoted_type',
        'quoted_contact_number',
        'message',
        'status',
        'read_at',
        'landlord_response',
        'responded_at'
    ];

    protected $casts = [
        'quoted_monthly_rent' => 'decimal:2',
        'read_at' => 'datetime',
        'responded_at' => 'datetime'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function messages()
    {
        return $this->hasMany(InquiryMessage::class)->orderBy('created_at');
    }

    // Attributes
    public function getMessageCountAttribute()
    {
        return $this->messages()->count();
    }

    // Helper methods
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    public function respond($response)
    {
        $this->update([
            'landlord_response' => $response,
            'responded_at' => now()
        ]);
    }
    public function addMessage($message, $isLandlord = false)
    {
        return $this->messages()->create([
            'message' => $message,
            'is_landlord' => $isLandlord
        ]);
    }


    public function canAddMoreMessages()
    {
        return $this->messages()->count() < 10;
    }

    // Status helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}