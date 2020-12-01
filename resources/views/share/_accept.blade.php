@can('accept', $model)
<a title="Click to mark as best answer" class="answer {{ $model->status }} off"
  onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit()">
  <i class="fas fa-check fa-2x"></i>
</a>
<form action="{{ route('answers.accept', [$model->id]) }}" id="accept-answer-{{ $model->id }}" method="POST"
  style="display: none">
  @csrf
</form>
@else
@if ($model->is_best)
<a title="Click to mark as best answer" class="{{ $model->status }} off">
  <i class="fas fa-check fa-2x"></i>
</a>
@endif
@endcan