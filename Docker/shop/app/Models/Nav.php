<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    const STATUS_YES = 1;
    const STATUS_NO = 2;
    const STATUS_DEL = 3;
    const TYPE_NAV = 1;
    const TYPE_BANNER = 2;
    const TYPE_ICON = 3;
    const TYPE_BIGIMG = 4;

    protected $table = 'pre_nav';
    // public $timestamps = false;

    protected $fillable = [
        'type_id', 'title', 'picture', 'link_type', 'link_target', 'sort', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
