<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $guarded = ['id'];
    public function user()
{
    return $this->belongsTo(User::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
protected $casts = [
    'payment_proof_date' => 'datetime',
];
}
