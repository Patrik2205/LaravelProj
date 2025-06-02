<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function allProducts()
    {
        $products = $this->products;
        
        foreach ($this->children as $child) {
            $products = $products->merge($child->allProducts());
        }
        
        return $products;
    }

    public static function tree()
    {
        return static::with('children')->whereNull('parent_id')->get();
    }
}