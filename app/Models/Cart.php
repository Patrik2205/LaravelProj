<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }

public static function getCart()
{
    if (auth()->check()) {
        return static::firstOrCreate(
            ['user_id' => auth()->id()],
            ['session_id' => session()->getId()]
        );
    }
    
    return static::firstOrCreate(['session_id' => session()->getId()]);
}
    public function addProduct(Product $product, $quantity = 1)
    {
        $item = $this->items()->where('product_id', $product->id)->first();
        
        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }
    }

    public function removeProduct(Product $product)
    {
        $this->items()->where('product_id', $product->id)->delete();
    }

    public function updateQuantity(Product $product, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeProduct($product);
        } else {
            $this->items()->where('product_id', $product->id)->update(['quantity' => $quantity]);
        }
    }

    public function clear()
    {
        $this->items()->delete();
    }
}