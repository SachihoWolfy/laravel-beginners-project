<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'score'];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function gameSessions()
    {
        return $this->hasMany(GameSession::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
