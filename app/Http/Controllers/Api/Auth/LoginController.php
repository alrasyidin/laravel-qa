<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
        //     $token = $user->createToken("Personal Access Token")->accessToken;
        //     $cookies = $this->getCookiesDetail($token);

        //     return response()
        //         ->json([
        //             'logged_in_user' => $user,
        //             'token' => $token,
        //         ], 200)
        //         ->cookie(
        //             $cookies['name'], 
        //             $cookies['value'], 
        //             $cookies['minutes'], 
        //             $cookies['path'], 
        //             $cookies['domain'], 
        //             $cookies['secure'], 
        //             $cookies['httponly'], 
        //             $cookies['samesite']
        //         );
            $request->request->add([
                'grant_type' => 'password',
                'client_id' => 10,
                'client_secret' => 'roCO6zP7OkypUfX4ZW6RxmMYbw5Q7Qfirc41XQsd',
                'username' => $request->email,
                'password' => $request->password,
            ]);

            $request = Request::create(env('APP_URL') . '/oauth/token', 'post');
            $response = Route::dispatch($request);
            return $response;
        } else {
            return response()->json(['error' => 'invalid-credentials'], 422);
        }
    }

    public function getCookiesDetail($token)
    {
        return [
            'name' => '_token',
            'value' => $token,
            'minutes' => 1440,
            'path' => null,
            'domain' => null,
            // 'secure' => true, // for production
            'secure' => null, // for localhost
            'httponly' => true,
            'samesite' => true,
        ];
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();
        $cookie = Cookie::forget("_token");
        return response()->json(null, 204)->withCookie($cookie);
    }
}
