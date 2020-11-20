@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      @include('layouts._message')

      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h3 class="m-0">All Questions</h3>
            <a href="{{ route('questions.create') }}" class="btn btn-primary ml-auto">Add Question</a>
          </div>
        </div>

        <div class="card-body">
          @foreach ($questions as $question)
          <div class="media">
            <div class="d-flex flex-column counters">
              <div class="vote">
                <strong>{{ $question->votes }}</strong> {{ Str::plural('vote', $question->votes) }}
              </div>
              <div class="status {{ $question->status }}">
                <strong>{{ $question->answers }}</strong> {{ Str::plural('answer', $question->answers) }}
              </div>
              <div class="view">
                {{ $question->views . " " . Str::plural('view', $question->views) }}
              </div>
              <div class=""></div>
            </div>
            <div class="media-body">
              <a href="{{ $question->url }}">
                <h1>{{ $question->title }}</h1>
              </a>
              <p class="lead">
                Asked By
                <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                <small class="text-muted">{{ $question->created_date }}</small>
              </p>
              {{ Str::limit($question->body, 250) }}
            </div>
          </div>
          <hr>
          @endforeach
          {{ $questions->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection