<?php

namespace Laraspace\Http\Controllers;

use Laraspace\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Image, Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if(!empty($request->avatar)) {
            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);
            $extension = (str_contains($exploded[0], 'jped')) ? 'jpg' : 'png';

            $fileName = str_random() .".".$extension;
            $path = public_path('/assets/img/avatars/').$fileName;
            file_put_contents($path, $decoded);

            Image::make($path)->resize(200, 200)->save($path);

            $user['avatar'] = $fileName;
        }
        
        $user['password'] = bcrypt($user['password']);
        User::create($user);

        return response()->json(['message' => 'Zarejestrowano'], 200);
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token and favorite recipes
        return response()->json([
            "token" => $token, 
            "favorite_recipes" => Auth::User()->favoriteRecipes()->get(),
            "my_recipes" => Auth::User()->recipes()->where('user_id', '=', Auth::User()->id)->get(),
            "avatar" => Auth::User()->avatar,
        ]);
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }

        return response([
            'authenticated' => true,
        ]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }

        return response()->json(['message' => 'Wylogowano'], 200);
    }
}
