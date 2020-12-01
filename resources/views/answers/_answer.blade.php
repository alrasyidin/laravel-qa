<div class="media post">
  <div class="d-flex flex-column align-items-center vote-control">
    @include('share/_vote', ['model' => $answer])
  </div>
  <div class="media-body">
    {!! $answer->body_html !!}
    <div class="row">
      <div class="col-4">
        <div class="ml-auto">
          @can('update', $answer)
          <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
            class="btn btn-sm btn-outline-info">Edit</a>
          @endcan

          @can('delete', $answer)
          <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id] ) }}" method="post"
            class="d-inline-block">
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
        @include('share/_author', [
        'model' => $answer,
        'label' => 'Dijawab'
        ])
      </div>
    </div>
  </div>
</div>