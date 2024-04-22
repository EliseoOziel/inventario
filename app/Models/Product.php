<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'category_id',
        'stock',
        'price',
        'image',
    ];

    //singular porque un producto puede tener unsa sola categoria
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
