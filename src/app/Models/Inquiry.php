<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

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
        'read_at',
        'landlord_response',
        'responded_at'
    ];

    protected $casts = [
        'quoted_monthly_rent' => 'decimal:2',
        'read_at' => 'datetime',
        'responded_at' => 'datetime'
    ];

    const MAX_MESSAGES = 10;
    const QUOTED_TYPES = ['monthly', 'yearly'];

    // Relationships
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function messages(): HasMany
    {
   
        return $this->hasMany(InquiryMessage::class);
    }
    // Attributes
    public function getMessageCountAttribute(): int
    {
        return $this->messages()->count();
    }

    public function getLastMessageAttribute()
{
    // Clear relationship cache
    $this->unsetRelation('messages');
    
    // Direct query for last message
    return InquiryMessage::where('inquiry_id', $this->id)
        ->orderByDesc('created_at')
        ->orderByDesc('id')
        ->first();
}
    // Message Methods
    public function addMessage(string $message, bool $isLandlord = false): InquiryMessage
    {
        if (!$this->canAddMoreMessages()) {
            throw new \Exception('Maximum message limit reached');
        }

        if (!$this->canReply()) {
            throw new \Exception('Not your turn to reply');
        }

        $newMessage = $this->messages()->create([
            'message' => $message,
            'is_landlord' => $isLandlord
        ]);

        Log::info('Message Added', [
            'inquiry_id' => $this->id,
            'message_id' => $newMessage->id,
            'is_landlord' => $isLandlord,
            'message_count' => $this->fresh()->message_count
        ]);

        return $newMessage;
    }

    public function canAddMoreMessages(): bool
    {
        return $this->message_count < self::MAX_MESSAGES;
    }

    public function canReply(): bool
{
    // Get last message directly using query builder
    $lastMessage = InquiryMessage::where('inquiry_id', $this->id)
        ->select('id', 'message', 'is_landlord', 'created_at')
        ->orderByDesc('created_at')
        ->orderByDesc('id')
        ->first();

    $currentUserIsLandlord = auth()->user()->role === 'landlord';

    // Debug log
    Log::info('Message Check', [
        'inquiry_id' => $this->id,
        'user_role' => auth()->user()->role,
        'messages_count' => $this->messages()->count(),
        'last_message' => $lastMessage ? [
            'id' => $lastMessage->id,
            'is_landlord' => (bool) $lastMessage->is_landlord,
            'message' => substr($lastMessage->message, 0, 50), // First 50 chars
            'created_at' => $lastMessage->created_at->toDateTimeString()
        ] : 'No messages'
    ]);

    if (!$lastMessage) {
        return !$currentUserIsLandlord;
    }

    return $lastMessage->is_landlord !== $currentUserIsLandlord;
}

   
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    public function respond(string $response): void
    {
        $this->update([
            'landlord_response' => $response,
            'responded_at' => now()
        ]);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function hasResponse(): bool
    {
        return !is_null($this->responded_at);
    }

    public function getRemainingMessagesCount(): int
    {
        return self::MAX_MESSAGES - $this->message_count;
    }

    public function isMaxMessagesReached(): bool
    {
        return $this->message_count >= self::MAX_MESSAGES;
    }
}