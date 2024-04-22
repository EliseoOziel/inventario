<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    //En plural porque una categoria puede estar en varios productos
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
