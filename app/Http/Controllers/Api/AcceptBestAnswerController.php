<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcceptBestAnswerController extends Controller
{
    public function __invoke(Answer $answer){
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'You have accepted this answer as best answer']);
        }
        
        return back();
    }
}
