<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'pidx',
        'user_id',
        'product_name',
        'product_id',
        'amount',
        'status',
        'payment_method',
        'khalti_response',
        'khalti_verification',
        'completed_at',
    ];

    protected $casts = [
        'khalti_response' => 'array',
        'khalti_verification' => 'array',
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
