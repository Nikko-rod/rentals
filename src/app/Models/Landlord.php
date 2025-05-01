<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use App\Enums\RejectionRemark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Landlord extends Model
{
    protected $fillable = [
        'user_id',
        'approval_status',
        'business_permit',
        'rejection_remark',
    ];

    protected $casts = [
        'approval_status' => ApprovalStatus::class,
        'rejection_remark' => 'string' 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->approval_status === ApprovalStatus::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->approval_status === ApprovalStatus::PENDING;
    }

    public function isRejected(): bool
    {
        return $this->approval_status === ApprovalStatus::REJECTED;
    }
    public function getRejectionMessage(): string
{
    return match($this->rejection_remark) {
        'blurry' => 'The uploaded document is too blurry to read',
        'corrupt_file' => 'The file appears to be corrupted',
        'expired_document' => 'The document has expired',
        'invalid_document' => 'Invalid document provided',
        'incomplete_information' => 'Document has incomplete information',
        default => 'Document was rejected'
    };
}
}