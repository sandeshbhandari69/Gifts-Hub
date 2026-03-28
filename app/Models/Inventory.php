<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_id',
        'category',
        'location',
        'available_quantity',
        'reserved_quantity',
        'on_hand_quantity',
        'description',
        'unit_cost',
    ];

    protected $casts = [
        'available_quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'on_hand_quantity' => 'integer',
        'unit_cost' => 'decimal:2',
    ];

    public function getStockStatusAttribute()
    {
        if ($this->available_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->available_quantity < 10) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function getStockStatusBadgeAttribute()
    {
        return match($this->stock_status) {
            'out_of_stock' => '<span class="badge bg-danger">Out of Stock</span>',
            'low_stock' => '<span class="badge bg-warning">Low Stock</span>',
            'in_stock' => '<span class="badge bg-success">In Stock</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
}
