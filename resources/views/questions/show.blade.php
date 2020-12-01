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
            <div class="d-flex flex-column align-items-center vote-control">
              <a href="" title="This question is useful" class="vote-up {{ auth()->guest() ? 'off' : '' }}"
                onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()"
                >
                <i class="fas fa-caret-up fa-3x"></i>
              </a>
              <form action="/questions/{{ $question->id }}/vote" id="up-vote-question-{{ $question->id }}" method="POST" style="display: none">
                @csrf
                <input type="text" name="vote" value="1">
              </form>

              <span class="votes-count">{{ $question->votes_count }}</span>
              
              <a href="" title="This question is useful" class="vote-down {{ auth()->guest() ? 'off' : '' }}"
                onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()"
                >
                <i class="fas fa-caret-down fa-3x"></i>
              </a>
              <form action="/questions/{{ $question->id }}/vote" id="down-vote-question-{{ $question->id }}" method="POST" style="display: none">
                @csrf
                <input type="text" name="vote" value="-1">
              </form>

              <a href="" title="Click to mark as favorite question" class="{{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '')  }}" onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit()">
                <i class="fas fa-star fa-2x"></i>
                <span class="favorite-count"><strong>{{ $question->favorites_count }}</strong></span>
              </a>
              <form action="/questions/{{ $question->id }}/favorite" id="favorite-question-{{ $question->id }}" method="POST" style="display: none">
                @csrf

                @if ($question->is_favorited)
                    @method('DELETE')
                @endif
              </form>
            </div>
            <div class="media-body">
              {!! $question->body_html !!}
              <div class="float-right">
                <span class="text-muted">Ditanya {{ $question->created_date }}</span>
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

  @include('answers._index', [
    'answersCount' => $question->answers_count,
    'answers' => $question->answers
  ])

  @include('answers._create', ['question_id' => $question->id])
</div>
@endsection