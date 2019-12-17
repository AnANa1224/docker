<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_YES = 1;
    const STATUS_NO = 2;
    const STATUS_DEL = 3;

    protected $table = 'pre_category';
    // public $timestamps = false;

    protected $fillable = [
        'name', 'property', 'sort',
    ];

    protected $attributes = [
        'sort' => 10,
        'status' => 1,
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }


}
