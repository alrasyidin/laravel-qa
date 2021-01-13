<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer, Request $request)
    {
        $vote = (int) $request->vote;

        $votesCount = Auth::user()->voteAnswer($answer, $vote);


        return response()->json([
            'message' => 'Thanks for your feedback',
            'votesCount' => $votesCount
        ], 200);
    }
}
