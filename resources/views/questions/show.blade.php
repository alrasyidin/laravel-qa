@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h2 class="m-0 w-75">{{ $question->title }}</h2>
            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary ml-auto">Back to all Question</a>
          </div>
        </div>

        <div class="card-body">
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
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h2>{{ $question->answers_count . " " . Str::plural('Answer', $question->answers_count)}}</h2>
        </div>
        <div class="card-body">
          @foreach ($question->answers as $answer)
          <div class="media">
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