<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "username" => "required|string",
            "password" => "required|string",
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 10,
            'client_secret' => 'roCO6zP7OkypUfX4ZW6RxmMYbw5Q7Qfirc41XQsd',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $request = Request::create(env('APP_URL') . '/oauth/token', 'post');
        $response = Route::dispatch($request);
        return $response;
    }

    public function destroy(Request $request){
        $request->user()->token()->revoke();
        return response()->json(null, 204);
    }
}
