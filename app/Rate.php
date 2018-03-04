<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'value', 'user_id', 'recipe_id',
    ];
}