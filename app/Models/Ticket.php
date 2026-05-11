<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'ticket_code',
        'status', 'amount_paid', 'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'amount_paid'  => 'decimal:2',
    ];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function user(): BelongsTo  { return $this->belongsTo(User::class); }
}