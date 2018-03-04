<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function recipesTags()
    {
        return $this->belongsToMany('Laraspace\Recipe', 'recipe_tags', 'tag_id', 'recipe_id')->withTimestamps();
    }
}
