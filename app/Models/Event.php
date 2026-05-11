<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organiser_id', 'title', 'description', 'start_date', 'end_date',
        'location', 'capacity', 'price', 'status', 'image_path',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'price'      => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function organiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organiser_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function activeTickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->where('status', 'active');
    }

    public function soldCount(): int
    {
        return $this->activeTickets()->count();
    }

    public function availableSpots(): int
    {
        return max(0, $this->capacity - $this->soldCount());
    }

    public function isSoldOut(): bool
    {
        return $this->availableSpots() === 0;
    }

    public function isFree(): bool
    {
        return (float) $this->price === 0.0;
    }

    public function revenue(): float
    {
        return (float) $this->tickets()->where('status', 'active')->sum('amount_paid');
    }

    public function isUpcoming(): bool
    {
        return $this->start_date->isFuture();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
}