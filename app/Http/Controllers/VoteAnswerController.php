<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer, Request $request)
    {
        $vote = (int) $request->vote;

        $votesCount = Auth::user()->voteAnswer($answer, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for your feedback',
                'votesCount' => $votesCount
            ], 200);
        }

        return back();
    }
}
