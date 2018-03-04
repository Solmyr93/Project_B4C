<?php

namespace Laraspace\Http\Controllers;

use Laraspace\Category;
use Laraspace\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ 
        	'categories' => Category::all('id', 'name'),
        	'tags' => Tag::all('id', 'name'),
        ];
    }
}
