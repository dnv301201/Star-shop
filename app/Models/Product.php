<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $guarded=[];
    use HasFactory;
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id');
    }
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class,'product_tags','product_id','tag_id')
            ->withTimestamps();
    }  
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    } 
    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class,'product_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
