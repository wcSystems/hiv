<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public $table = 'history_machine_users';

    protected $fillable = [
        'machine_id',
        'user_id',
        'monto',
    ];
}
