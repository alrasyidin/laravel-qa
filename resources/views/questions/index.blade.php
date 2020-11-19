@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          All Questions
        </div>

        <div class="card-body">
          @foreach ($questions as $question)
          <div class="media">
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