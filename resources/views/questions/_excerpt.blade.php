<div class="media post">
  <div class="d-flex flex-column counters">
    <div class="vote">
      <strong>{{ $question->votes_count }}</strong> {{ Str::plural('vote', $question->votes_count) }}
    </div>
    <div class="status {{ $question->status }}">
      <strong>{{ $question->answers_count }}</strong> {{ Str::plural('answer', $question->answers_count) }}
    </div>
    <div class="view">
      {{ $question->views . " " . Str::plural('view', $question->views) }}
    </div>
  </div>
  <div class="media-body">
    <div class="d-flex align-items-center">
      <a href="{{ $question->url }}" class="w-75">
        <h4>{{ $question->title }}</h4>
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
    {!! $question->excerpt !!}
  </div>
</div>