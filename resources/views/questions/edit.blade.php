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
          <form action="{{ route("questions.update", $question->id) }}" method="post">
            @method('PUT')
            @include('questions._forms', ['buttonText' => 'Edit this Question'])
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection