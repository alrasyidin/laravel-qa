<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question){
        return $question->answers()->with('user')->simplePaginate(3);       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question,Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $answer = $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Success submit your answer',
                'answer' => Answer::with('user')->find($answer->id)
            ]);
        }

        return back()->with('success', 'Success submit your answer');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        $request->validate([
            'body' => 'required'
        ]);

        $answer->update([
            'body' => $request->body
        ]);

        if($request->expectsJson()){
            return response()->json([
                'message' => 'Update question to database succesfully',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $delete = $answer->delete();

        // bisa dilakukan dengan cara ini atau dengan event
        // if ($delete) {
        //     $question->decrement('answers_count');
        // }

        if(request()->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been removed',
            ]);
        }

        return back()->with('success', 'Your answer has been removed');
    }
}