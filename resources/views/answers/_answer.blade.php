<answer :answer="{{ $answer }}" inline-template>
  <div class="media post">
    <div class="d-flex flex-column align-items-center vote-control">
      @include('share/_vote', ['model' => $answer])
    </div>
    <div class="media-body">
      <form v-if="editing" v-on:submit.prevent="update">
        <div class="form-group">
          <textarea rows="8" v-model="body" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-sm btn-primary" :disabled="isInvalid">Update</button>
        <button class="btn btn-sm btn-secondary" @click.prevent="cancel">Cancel</button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              @can('update', $answer)
              <a @click.prevent="edit"
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
  </div>
</answer>