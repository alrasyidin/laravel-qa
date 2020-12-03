<answer :answer="{{ $answer }}" inline-template>
  <div class="media post">
    {{-- vote component --}}
    <vote name="answer" :model="{{ $answer }}"></vote>

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
              <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
              @endcan

              @can('delete', $answer)
              <button class="btn btn-sm btn-outline-danger" @click="destroy">Delete</button>
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