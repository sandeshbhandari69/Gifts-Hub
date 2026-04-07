<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = [
    'p_name',
    'p_price',
    'c_id',
    'p_stock',
    'p_description',
    'p_image',
    'status'
    ];

    function category()
    {
        return $this->belongsTo(Category::class, 'c_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'p_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => '<span class="badge rounded-pill bg-success">Active</span>',
            'inactive' => '<span class="badge rounded-pill bg-secondary">Inactive</span>',
            'out_of_stock' => '<span class="badge rounded-pill bg-danger">Out of Stock</span>',
            'discontinued' => '<span class="badge rounded-pill bg-dark">Discontinued</span>',
            default => '<span class="badge rounded-pill bg-warning">Unknown</span>'
        };
    }

    protected $primaryKey = 'p_id';

}
