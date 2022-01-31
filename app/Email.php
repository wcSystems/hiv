<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'remitente', 'destinatario','asunto','estado','user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
  
}
