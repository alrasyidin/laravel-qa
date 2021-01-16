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

          <div class="card-body">
            <div v-if="questions">
              <question-excerpt
                v-for="question in questions"
                :key="question.id"
                :question="question"
              ></question-excerpt>
            </div>
            <div v-else class="alert alert-warning">
              <strong>Sorry</strong> There are no questions available.
            </div>

            <!-- {{ pagination here }} -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import QuestionExcerpt from '../components/QuestionExcerpt'

export default {
  name: 'QuestionsPage',
  data() {
    return {
      questions: [],
    }
  },
  components: {
    QuestionExcerpt,
  },
  created() {
    this.fetchQuestions()
  },
  methods: {
    fetchQuestions() {
      axios.get('/questions').then(({data}) => {
		  console.log(data)
		  this.questions = data.data
	  })
    },
  },
}
</script>
