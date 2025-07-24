<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_type',
        'bank',
        'status',
        'snap_token'
    ];
}
