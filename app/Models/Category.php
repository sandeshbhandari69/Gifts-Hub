<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [
        'c_name',
    ];

    protected $primaryKey = 'c_id';

    public function products()
    {
        return $this->hasMany(Product::class, 'c_id', 'c_id');
    }
}
