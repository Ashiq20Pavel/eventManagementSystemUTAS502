<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'event_type', 'ip_address',
        'user_agent', 'success', 'failure_reason',
    ];

    protected $casts = [
        'success'    => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public static function record(
        ?int $userId,
        string $eventType,
        bool $success = true,
        ?string $failureReason = null
    ): void {
        static::create([
            'user_id'        => $userId,
            'event_type'     => $eventType,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'success'        => $success,
            'failure_reason' => $failureReason,
        ]);
    }
}