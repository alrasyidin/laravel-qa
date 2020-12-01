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
          @forelse ($questions as $question)
            @include('questions/_excerpt')
          @empty
            <div class="alert alert-warning">
              <strong>Sorry</strong> There are no questions available.
            </div>
          @endforelse
          {{ $questions->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection