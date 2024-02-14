<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeQuantity extends Model
{
    use HasFactory;
    protected $fillable = ['size', 'quantity', 'product_attribute_id'];

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
