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
            </div>
            <div class="media-body">
              <div class="d-flex align-items-center">
                <a href="{{ $question->url }}" class="w-75">
                  <h1>{{ $question->title }}</h1>
                </a>
                <div class="ml-auto">
                  {{-- bisa juga menggunakan directive @can --}}

                  {{-- @if (auth()->user()->can('update', $question))
                  <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                  @endif --}}

                  @can('update', $question)
                  <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                  @endcan

                  

                  {{-- @if (auth()->user()->can('delete', $question))
                  <form action="{{ route('questions.destroy', $question->id) }}" method="post" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Are you sure delete this question?');" type="submit">Delete</button>
                  </form>
                  @endif --}}

                  {{-- menggunakan @can --}}
                  @can('delete', $question)
                  <form action="{{ route('questions.destroy', $question->id) }}" method="post" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Are you sure delete this question?');" type="submit">Delete</button>
                  </form>
                  @endcan
                </div>
              </div>
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