<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
          'address',        
    'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function landlord(): HasOne
    {
        return $this->hasOne(Landlord::class);
    }
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }
    public function isLandlord(): bool
    {
        return $this->role === 'landlord';
    }
public function isAdmin(): bool
{
    return $this->role === 'admin';
}
    public function getApprovalStatus(): string
    {
        return $this->landlord?->approval_status ?? ApprovalStatus::PENDING->value;
    }
    public function isApproved(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::APPROVED->value;
    }
    public function isPending(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::PENDING->value;
    }
    public function isRejected(): bool
    {
        return $this->getApprovalStatus() === ApprovalStatus::REJECTED->value;
    }
    
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }
    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
    public function sentInquiries()
{
    return $this->hasMany(Inquiry::class, 'tenant_id');
}

public function receivedInquiries()
{
    return $this->hasMany(Inquiry::class, 'landlord_id');
}


}