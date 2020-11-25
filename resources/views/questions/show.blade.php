@extends('layouts.app')

@section('content')
<div class="container">
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
            <div class="d-flex flex-column align-items-center vote-control">
              <a title="This question is useful" class="vote-up">
                <i class="fas fa-caret-up fa-3x"></i>
              </a>
              <span class="votes-count">1200</span>
              <a title="This question is useful" class="vote-down off">
                <i class="fas fa-caret-down fa-3x"></i>
              </a>
              <a title="Click to mark as favorite question" class="favorited">
                <i class="fas fa-star fa-2x"></i>
              </a>
              <span class="favorite-count">123</span>
            </div>
            <div class="media-body">
              {!! $question->body_html !!}
              <div class="float-right">
                <span class="text-muted">Dijawab {{ $question->created_date }}</span>
                <div class="media mt-1">
                  <a href="{{ $question->user->url }}" class="pr-2">
                    <img src="{{ $question->user->avatar }}" alt="Avatar User">
                  </a>
                  <div class="media-body mt-2">
                    <a href="{{ $question->user->url }}" class="">{{ $question->user->name }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h2>{{ $question->answers_count . " " . Str::plural('Answer', $question->answers_count)}}</h2>
          </div>
          <hr>
          @foreach ($question->answers as $answer)
          <div class="media">
            <div class="d-flex flex-column align-items-center vote-control">
              <a title="This answer is useful" class="vote-up">
                <i class="fas fa-caret-up fa-3x"></i>
              </a>
              <span class="votes-count">1200</span>
              <a title="This answer is useful" class="vote-down off">
                <i class="fas fa-caret-down fa-3x"></i>
              </a>
              <a title="Click to mark as best answer" class="vote-accepted off">
                <i class="fas fa-check fa-2x"></i>
              </a>
            </div>
            <div class="media-body">
              {!! $answer->body_html !!}
              <div class="float-right">
                <span class="text-muted">Dijawab {{ $answer->created_date }}</span>
                <div class="media mt-1">
                  <a href="{{ $answer->user->url }}" class="pr-2">
                    <img src="{{ $answer->user->avatar }}" alt="Avatar User">
                  </a>
                  <div class="media-body mt-2">
                    <a href="{{ $answer->user->url }}" class="">{{ $answer->user->name }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection