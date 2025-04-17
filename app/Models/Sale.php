<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'payment_method',
        'sale_date',
    ];

    public function itens()
    {
        return $this->hasMany(SaleItem::class);
    }

    protected $casts = [
        'sale_date' => 'datetime',
    ];
}
