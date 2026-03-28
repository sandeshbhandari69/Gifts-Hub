<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'billing_data',
        'items',
        'total',
        'payment_method',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'billing_data' => 'array',
        'items' => 'array',
        'total' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBillingAttribute()
    {
        return $this->billing_data;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'processing' => '<span class="badge rounded-pill bg-secondary">Processing</span>',
            'shipped' => '<span class="badge rounded-pill bg-success">Shipped</span>',
            'delivered' => '<span class="badge rounded-pill bg-primary">Delivered</span>',
            'cancelled' => '<span class="badge rounded-pill bg-danger">Cancelled</span>',
            'on_the_way' => '<span class="badge rounded-pill bg-info">On the way</span>',
            default => '<span class="badge rounded-pill bg-warning">Pending</span>'
        };
    }
}
