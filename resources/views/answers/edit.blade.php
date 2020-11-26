@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h3>Answer for this question: <strong>{{ $question->title }}</strong></h3>
          </div>
          <hr>
          <form action="{{ route('questions.answers.update', ['question' => $question->id, 'answer' => $answer->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" cols="30" rows="10">{{ old('body', $answer->body) }}</textarea>
              @if ($errors->has('body'))
              <div class="invalid-feedback">
                {{ $errors->first('body') }}
              </div>
              @endif
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection