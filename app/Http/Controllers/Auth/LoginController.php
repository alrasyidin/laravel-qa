<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getToken(Request $request)
    {
        $login = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        // if (Auth::attempt($login)) {
            $request->request->add([
                'grant_type' => 'password',
                'client_id' => 10,
                'client_secret' => 'roCO6zP7OkypUfX4ZW6RxmMYbw5Q7Qfirc41XQsd',
                'username' => $request->email,
                'password' => $request->password
            ]);

            $request = Request::create(env('APP_URL') . '/oauth/token', 'post');
            $response = Route::dispatch($request);
            return $response;

            // $user = Auth::user();
            // $token = $user->createToken("Personal Access Token")->accessToken;
            // $response = Route::dispatch();
            // return $response;
        // } 
        // else {
        //     // return response()->json(['error' => 'invalid-credentials'], 422);
        // }
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
}
