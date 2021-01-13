<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());

        return response()->json(null, 204);
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        return response()->json(null, 204);
    }
}
