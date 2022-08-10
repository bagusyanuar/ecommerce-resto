<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'nama',
        'qty',
        'harga',
        'deskripsi',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function success_cart()
    {
        return $this->hasMany(Cart::class, 'product_id')
            ->join('transactions', function ($join) {
                $join->on([
                    ['carts.transaction_id', '=', 'transactions.id'],
                ])->where('transactions.status', '!=', 'selesai');
            });
    }

    public function getSellAttribute()
    {
        $cart = $this->success_cart()->get();
        $total = 0;
        foreach ($cart as $v) {
            $total += $v->qty;
        }
        return $total;
    }
}
