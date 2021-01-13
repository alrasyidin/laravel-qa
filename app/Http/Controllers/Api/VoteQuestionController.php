<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question, Request $request)
    {
        $vote = (int) $request->vote;

        $votesCount = Auth::user()->voteQuestion($question, $vote);

        return response()->json([
            'message' => 'Thanks for your feedback',
            'votesCount' => $votesCount
        ], 200);
    }
}
