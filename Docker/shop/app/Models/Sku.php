<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    const STATUS_YES = 1;
    const STATUS_NO = 2;
    const STATUS_DEL = 3;

    protected $table = 'pre_sku';
    
    // public $timestamps = false;

    protected $fillable = [
        'product_id', 'original_price', 'price', 'attr1', 'attr2', 'attr3', 'quantuty', 'sort', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
