<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_YES = 1;
    const STATUS_NO = 2;
    const STATUS_DEL = 3;

    protected $table = 'orders';
    // public $timestamps = false;

    protected $fillable = [
        'user_id', 'product_id', 'order', 'status'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];
}
