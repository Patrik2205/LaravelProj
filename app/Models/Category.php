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

    public function allProductsQuery()
    {
        // Get all descendant category IDs including this one
        $categoryIds = collect([$this->id]);
        $this->getAllDescendantIds($categoryIds);
    
        return Product::whereIn('category_id', $categoryIds);
    }

    private function getAllDescendantIds(&$ids)
    {
        foreach ($this->children as $child) {
            $ids->push($child->id);
            $child->getAllDescendantIds($ids);
        }
    }
    public static function tree()
    {
        return static::with('children')->whereNull('parent_id')->get();
    }
}