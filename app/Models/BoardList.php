<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    use HasFactory;
    protected $table = 'board_lists';
    protected $fillable = [
        'name',
        'order',
        'board_id'
    ];
}
