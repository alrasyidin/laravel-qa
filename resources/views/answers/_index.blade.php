<div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h2>{{ $answersCount . " " . Str::plural('Answer', $answersCount)}}</h2>
          </div>
          <hr>
          @foreach ($answers as $answer)
          <div class="media">
            <div class="d-flex flex-column align-items-center vote-control">
              <a title="This answer is useful" class="vote-up {{ auth()->guest() ? 'off' : '' }}"
                onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit()">
                <i class="fas fa-caret-up fa-3x"></i>
              </a>
              <form action="/answers/{{ $answer->id }}/vote" id="up-vote-answer-{{ $answer->id }}" method="POST" style="display: none">
                @csrf
                <input type="text" name="vote" value="1">
              </form>

              <span class="votes-count">{{ $answer->votes_count }}</span>

              <a title="This answer is useful" class="vote-down {{ auth()->guest() ? 'off' : '' }}"
                onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit()">
                <i class="fas fa-caret-down fa-3x"></i>
              </a>
              <form action="/answers/{{ $answer->id }}/vote" id="down-vote-answer-{{ $answer->id }}" method="POST" style="display: none">
                @csrf
                <input type="text" name="vote" value="-1">
              </form>

              @can('accept', $answer)
                <a title="Click to mark as best answer" class="vote {{ $answer->status }} off" onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit()">
                  <i class="fas fa-check fa-2x"></i>
                </a>
                <form action="{{ route('answers.accept', [$answer->id]) }}" id="accept-answer-{{ $answer->id }}" method="POST" style="display: none">
                  @csrf
                </form>
              @else
                @if ($answer->is_best)
                <a title="Click to mark as best answer" class="{{ $answer->status }} off">
                  <i class="fas fa-check fa-2x"></i>
                </a>
                @endif
              @endcan
            </div>
            <div class="media-body">
              {!! $answer->body_html !!}
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    @can('update', $answer)
                    <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                    @endcan
  
                    @can('delete', $answer)
                    <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id] ) }}" method="post" class="d-inline-block">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure delete this question?');" type="submit">Delete</button>
                    </form>
                    @endcan
                  </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
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
          </div>
          <hr>
          @endforeach
        </div>
      </div>
    </div>
  </div>