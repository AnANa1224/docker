<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_YES = 1;
    const STATUS_NO = 2;
    const STATUS_DEL = 3;

    protected $table = 'pre_product';
    // public $timestamps = false;

    protected $fillable = [
        'category_id', 'name', 'content', 'sort', 'status'
    ];

    public function categorys()
    {
        return $this->hasMany('App\Models\Categoy');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

}
