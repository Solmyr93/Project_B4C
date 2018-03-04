<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;
use Laraspace\Http\Requests;
use Laraspace\Category;
use Laraspace\Tag;
use Auth;

class ResourcesController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function storeCategory(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
      $data = $this->validate($request, [
        'name' => 'required',
        'parent_category_id' => 'required',
      ]);

      Category::create($data);
      return response()->json(['message' => 'Dodano nową kategorię'], 200);
    }
    
    abort('403');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function storeTag(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
      $data = $this->validate($request, [
        'name' => 'required',
      ]);

      Tag::create($data);
      return response()->json(['message' => 'Dodano nowy tag'], 200);
    }
    
    abort('403');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateCategory(Request $request, $id)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
      $data = $this->validate($request, [
        'name' => 'required',
        'parent_category_id' => 'required',
      ]);

      $category = Category::find($id);
      $category->update($data);

      return response()->json(['message' => 'Zaktualizowano kategorię'], 200);
    }
    
    abort('403');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateTag(Request $request, $id)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
      $data = $this->validate($request, [
        'name' => 'required',
      ]);

      $tag = Tag::find($id);
      $tag->update($data);

      return response()->json(['message' => 'Zaktualizowano tag'], 200);
    }
    
    abort('403');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function deleteTag($id)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
    	$tag = Tag::find($id);
      $tag->recipesTags()->detach();
      $tag->delete();

      return response()->json(['message' => 'Usunięto tag'], 200);
    } else {
      abort('403');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function deleteCategory($id)
  {
    if(JWTAuth::parseToken()->authenticate() && Auth::user()->role == "admin") {
    	$category = Category::find($id);
    	$parent_category = Category::find($category->parent_category_id);

      foreach($category->recipes as $recipe) {
      	$recipe->update(['subcategory_id' => $parent_category->id]);
      }
      
      $category->delete();

      return response()->json(['message' => 'Usunięto kategorię'], 200);
    } else {
      abort('403');
    }
  }
}
