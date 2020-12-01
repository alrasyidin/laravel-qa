<a href="" title="Click to mark as favorite {{ $name }}"
  class="{{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '')  }}"
  onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit()">
  <i class="fas fa-star fa-2x"></i>
  <span class="favorite-count"><strong>{{ $model->favorites_count }}</strong></span>
</a>
<form action="/{{ $firstURISegment }}/{{ $model->id }}/favorite" id="favorite-{{ $name }}-{{ $model->id }}"
  method="POST" style="display: none">
  @csrf

  @if ($model->is_favorited)
  @method('DELETE')
  @endif
</form>