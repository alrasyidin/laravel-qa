@extends('layouts.app')

@section('content')
<div class="container">
  @include('layouts._message')  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <div class="d-flex align-items-center">
              <h2 class="m-0 w-75">{{ $question->title }}</h2>
              <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary ml-auto">Back to all Question</a>
            </div>
          </div>

          <hr>

          <div class="media">
            {{-- vote component --}}
            <vote name="question" :model="{{ $question }}"></vote>

            <div class="media-body">
              {!! $question->body_html !!}
              <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4">
                  {{-- @include('share/_author', [
                    'model' => $question,
                    'label' => 'Ditanya'
                  ]) --}}

                  <user-info :model="{{ $question }}" label="Ditanya"></user-info>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include('answers._index', [
    'answersCount' => $question->answers_count,
    'answers' => $question->answers
  ])

  @include('answers._create', ['question_id' => $question->id])
</div>
@endsection