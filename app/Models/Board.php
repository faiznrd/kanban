<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $table = 'boards';
    protected $fillable = [
        'name',
        'creator_id'
    ];

    public function members(){
        return $this->belongsToMany(User::class, 'board_members');
    }

    public function lists(){
        return $this->hasMany(BoardList::class, 'board_id');
    }
}
