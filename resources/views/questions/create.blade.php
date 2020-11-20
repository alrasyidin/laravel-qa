@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h3 class="m-0">Ask Questions</h3>
            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary ml-auto">Back to all Question</a>
          </div>
        </div>

        <div class="card-body">
          <form action="{{ route("questions.store") }}" method="post">
            @csrf
            <div class="form-group">
              <label for="question-title">Question Title</label>
              <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="question-title" value="{{ old('title') ? old('title') : '' }}">

              @if ($errors->has('title'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('title') }}</strong>
              </div>
              @endif
            </div>

            <div class="form-group">
              <label for="question-body">Explain your question</label>
              <textarea name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" id="question-body" rows="10">{{ old('body') ? old('body') : '' }}</textarea>

              @if ($errors->has('body'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('body') }}</strong>
              </div>
              @endif
            </div>

            <div class="form-group">
              <button class="btn btn-primary btn-large">Ask a Question</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection