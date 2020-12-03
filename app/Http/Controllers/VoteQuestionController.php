<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteQuestionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke(Question $question, Request $request){
        $vote = (int) $request->vote;

        $votesCount = Auth::user()->voteQuestion($question, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for your feedback',
                'votesCount' => $votesCount
            ], 200);
        }

        return back();
    }
}
