<?php

namespace Laraspace\Http\Controllers;

use Laraspace\Rate;
use Laraspace\Comment;
use Laraspace\Recipe;
use Illuminate\Http\Request;
use Auth;

class InteractionsController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function storeComment(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate()) {
      $data = $this->validate($request, [
        'text' => 'required',
        'recipe_id' => 'required',
      ]);

      $data['user_id'] = Auth::user()->id;
      Comment::create($data);

      return response()->json(['message' => 'Dodano nowy komentarz'], 200);
    }
    
    abort('403', "Błąd, nie zalogowany użytkownik");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function storeRate(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate()) {
      $data = $this->validate($request, [
        'value' => 'required',
        'recipe_id' => 'required',
      ]);

      $data['user_id'] = Auth::user()->id;
      $rate = Rate::firstOrNew(['user_id' => $data['user_id'], 'recipe_id' => $data['recipe_id']]);
      $rate->value = $data['value'];
			$rate->save();

      return response()->json(['message' => 'Dodano nową ocenę'], 200);
    }
    
    abort('403', "Błąd, nie zalogowany użytkownik");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function addToFavorities(Request $request)
  {
    if(JWTAuth::parseToken()->authenticate()) {
      $data = $this->validate($request, [
        'recipe_id' => 'required',
      ]);

      $data['user_id'] = Auth::user()->id;
      $recipe = Recipe::find($data['recipe_id']);
      $recipe->favoriteRecipes()->toggle($data);

      return response()->json(['message' => 'Zmiana w ulubionych'], 200);
    }
    
    abort('403', "Błąd, nie zalogowany użytkownik");
  }
}
