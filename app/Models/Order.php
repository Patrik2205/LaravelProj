<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email', 'name', 'phone', 'address', 'total', 'status'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function createFromCart(Cart $cart, array $data)
    {
        $order = static::create([
            'user_id' => auth()->id(),
            'email' => $data['email'] ?? auth()->user()->email,
            'name' => $data['name'] ?? auth()->user()->name,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'total' => $cart->total,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        $cart->clear();

        return $order;
    }
}