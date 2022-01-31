<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;

class Team extends Model
{
    protected $fillable = [
        'title','group','team_id','ip','user','password','description'
    ];

    public function parent()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function children()
    {
        return $this->hasMany(Team::class, 'team_id');
    }
}
