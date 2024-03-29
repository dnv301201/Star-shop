<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')
                ->withPivot('color', 'size', 'quantity')
                    ->withTimestamps();
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'cart_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
