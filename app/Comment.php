<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text', 'recipe_id', 'user_id',
    ];
    
}
