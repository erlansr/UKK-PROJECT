<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'user_id', 'total', 'status', 'alamat', 
        'no_hp', 'catatan', 'jasa_pengiriman', 'metode_pembayaran',
        'payment_confirmed', 'payment_confirmed_at'
    ];

    protected $casts = [
        'payment_confirmed' => 'boolean',
        'payment_confirmed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}