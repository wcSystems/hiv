<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'block_id','type_id','network_id','host','name','username','password','ssid','ssid_password','description','mac',
    ];
}
