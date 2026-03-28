<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'supplier',
        'inventory_id',
        'quantity',
        'unit_cost',
        'total_amount',
        'notes',
        'purchase_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            if (empty($purchase->purchase_id)) {
                $purchase->purchase_id = 'PUR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            }
            if (empty($purchase->total_amount)) {
                $purchase->total_amount = $purchase->quantity * $purchase->unit_cost;
            }
        });
    }
}
