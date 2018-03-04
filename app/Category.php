<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_category_id'];

    public function recipes()
    {
        return $this->hasMany('Laraspace\Recipe', 'subcategory_id');
    }
}
