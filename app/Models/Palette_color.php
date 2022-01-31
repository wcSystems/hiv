<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Palette_color extends Model
{
    protected $table = 'palette_colors';

    protected $fillable = [
        'user_id', 'color_primary', 'color_secondary', 'color_tertiary'
    ];

    public function users(){
        return $this->hasOne(User::class);
    }
}
