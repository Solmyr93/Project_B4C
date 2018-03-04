<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'subcategory_id', 'ingredients'];

    public function user()
    {
        return $this->belongsTo('Laraspace\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('Laraspace\Category', 'subcategory_id');
    }

    public function rate()
    {
    	return $this->belongsTo('Laraspace\Rate', 'id', 'recipe_id');
    }

    public function comment()
    {
        return $this->belongsTo('Laraspace\Comment', 'id', 'recipe_id');
    }

    public function recipesTags()
    {
        return $this->belongsToMany('Laraspace\Tag', 'recipe_tags', 'recipe_id', 'tag_id')->withTimestamps();
    }

    public function favoriteRecipes()
    {
        return $this->belongsToMany('Laraspace\User', 'favorite_recipe', 'recipe_id', 'user_id')->withTimestamps();
    }
}
