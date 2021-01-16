<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h3 class="m-0">All Questions</h3>
              <a href="#" class="btn btn-primary ml-auto">Add Question</a>
            </div>
          </div>

          <questions :questions="questions"></questions>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Questions from '../components/Questions'

export default {
  name: 'QuestionsPage',
  data() {
    return {
      questions: [],
    }
  },
  components: {
    Questions
  }
}
</script>
