<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPostController extends Controller
{
    public function __invoke(Request $request)
    {
        // test
        return response()->json([
            "data" => $request->user()->posts($request->type)
        ]);
    }
}
