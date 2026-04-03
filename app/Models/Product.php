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
    'p_image'
    ];

    function category()
    {
        return $this->belongsTo(Category::class, 'c_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'p_id');
    }

    protected $primaryKey = 'p_id';

}
