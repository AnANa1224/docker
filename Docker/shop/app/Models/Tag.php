<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    const STATUS_YES=1;
    const STATUS_NO=2;
    const STATUS_DEL=3;
    const PICTURE_TAG=1;
    const PROPAGANDA_TAG=2;
    const LIFT_TAG=3;

    protected $table = 'pre_product_tag';
    // public $timestamps = false;

    protected $fillable = [
        'product_id', 'tag_id', 'value', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
