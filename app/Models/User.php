<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // ERD uses password_hash column name
    protected $authPasswordName = 'password_hash';

    protected $fillable = [
        'role', 'name', 'email', 'password_hash',
        'email_verified_at', 'remember_token',
    ];

    protected $hidden = ['password_hash', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    // Map Laravel's default 'password' auth field to 'password_hash'
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isOrganiser(): bool { return $this->role === 'organiser'; }
    public function isAttendee(): bool  { return $this->role === 'attendee'; }
    public function isStaff(): bool     { return in_array($this->role, ['admin', 'organiser']); }

    public function organisedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organiser_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function authLogs(): HasMany
    {
        return $this->hasMany(AuthLog::class);
    }

    public function passwordResets(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }
}