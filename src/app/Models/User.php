<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'contact_number',
        'role',
        'is_archived',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the landlord associated with the user.
     */
    public function landlord(): HasOne
    {
        return $this->hasOne(Landlord::class);
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check if the user is a tenant.
     */
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }

    /**
     * Check if the user is a landlord.
     */
    public function isLandlord(): bool
    {
        return $this->role === 'landlord';
    }

    /**
     * Get the landlord's approval status.
     */
    public function getApprovalStatus(): string
    {
        return $this->landlord?->approval_status ?? ApprovalStatus::PENDING->value;
    }

    /**
     * Check if the landlord is approved.
     */
    public function isApproved(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::APPROVED->value;
    }

    /**
     * Check if the landlord is pending approval.
     */
    public function isPending(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::PENDING->value;
    }

    /**
     * Check if the landlord was rejected.
     */
    public function isRejected(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::REJECTED->value;
    }

    /**
     * Scope a query to only include tenants.
     */
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }

    /**
     * Scope a query to only include landlords.
     */
    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }
}