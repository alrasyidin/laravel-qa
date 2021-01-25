<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AskQuestionRequest;
use App\Http\Resources\QuestionsResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')
            ->latest()
            ->paginate(10);

        return QuestionsResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        try {
            $question = $request->user()->questions()->create($request->only('title', 'body'));
    
            return response()->json([
                'message' => 'Your questions has been submitted',
                'question' => new QuestionsResource($question)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' =>  $th
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');

        return response()->json([
            'title' => $question->title,
            'body' => $question->body,
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
        
        $this->authorize('update', $question);

        $question->update($request->only('title', 'body'));

        return response()->json([
            'message' => 'Update question to database succesfully',
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        return response()->json([
            'message' => 'Success delete question',
        ]);
    }
}
