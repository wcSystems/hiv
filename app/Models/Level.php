<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public $table = 'levels';

    protected $fillable = [
        'name'
    ];
}
