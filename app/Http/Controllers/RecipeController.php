<?php

namespace Laraspace\Http\Controllers;

use JWTAuth;
use Laraspace\Recipe;
use Illuminate\Http\Request;
use Laraspace\Http\Controllers\Controller;
use Auth;

class RecipeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [];
    $recipes = Recipe::orderBy('updated_at')->get();

    foreach($recipes as $recipe) {
      // echo $recipe;

      $data[] = array_merge($recipe->toArray(), [
        'user' => $recipe->user()->first(['id', 'first_name', 'last_name']),
        'category' => $recipe->category()->first(['id', 'name']),
        'avg_rate' => number_format($recipe->rate()->avg('value'), 2),
        'tags' => $recipe->recipesTags()->get(),
      ]);
    }

    return $data;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate()) {
      $recipe = $this->validate($request, [
        'name' => 'required',
        'tags' => 'nullable|exists:tags,id',
        'subcategory_id' => 'required|exists:categories,id',
        'ingredients' => 'required',
        'description' => 'required'
      ]);

      $tags = $recipe['tags'];
      $recipe['user_id'] = Auth::user()->id;
      $recipe = Recipe::create($recipe);

      if($recipe->id > 0 && is_array($tags) && sizeof($tags) > 0) {
        $recipe->recipesTags()->attach($tags);
      }

      return response()->json(['message' => 'Dodano przepis'], 200);
    }

    abort('403', "Brak uprawnień");
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Recipe  $recipe
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $recipe = Recipe::find($id);

    if(!empty($recipe)) {
      $userRate = "";

      if(JWTAuth::parseToken()->authenticate()) {
        $userRate = $recipe->rate()->where('user_id', '=', Auth::user()->id)->first(['value']);
      }

      return array_merge($recipe->toArray(), [
        'avg_rate' => number_format($recipe->rate()->avg('value'), 2),
        'user_rate' => $userRate,
        'category' => $recipe->category()->first(['name']),
        'user' => $recipe->user()->first(['first_name', 'last_name']),
        'recipe_tags' => $recipe->recipesTags()->get(),
        'comments' => $recipe->comment()->get(['text']),
        'can_user_modify' => (JWTAuth::parseToken()->authenticate() && ((int)Auth::user()->id == (int)$recipe['user_id'] || Auth::user()->role == "admin") && (int)$recipe['user_id'] > 0),
      ]);
    }

    abort('403', "Brak rekordu w bazie");
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $recipe = Recipe::find($id);

    if(JWTAuth::parseToken()->authenticate() && ((int)Auth::user()->id == (int)$recipe['user_id'] || Auth::user()->role == "admin") && (int)$recipe['user_id'] > 0) {

      $data = $this->validate($request, [
        'name' => 'required',
        'tags' => 'nullable|exists:tags,id',
        'subcategory_id' => 'required|exists:categories,id',
        'ingredients' => 'required',
        'description' => 'required'
      ]);

      $recipe->update($data);
      $recipe->recipesTags()->sync($data['tags']);

      return response()->json(['message' => 'Zaktualizowano przepis'], 200);
    }

    abort('403', "Brak uprawnień");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $recipe = Recipe::find($id);

    if(JWTAuth::parseToken()->authenticate() && (int)Auth::user()->id == (int)$recipe['user_id'] && (int)$recipe['user_id'] > 0) {
      $recipe->recipesTags()->detach();
      $recipe->delete();

      return response()->json(['message' => 'Usunięto przepis'], 200);
    } else {
      abort('403', "Brak uprawnień");
    }
  }
}
