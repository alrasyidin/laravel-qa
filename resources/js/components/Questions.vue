<template>
  <div>
    <div class="card-body">
      <div v-if="questions">
        <question-excerpt
          @deleted="remove(index)"
          v-for="(question, index) in questions"
          :key="index"
          :question="question"
        ></question-excerpt>
      </div>
      <div v-else class="alert alert-warning">
        <strong>Sorry</strong> There are no questions available.
      </div>

      <!-- {{ pagination here }} -->
    </div>
    <div class="card-footer">
      <pagination :links="links" :meta="meta"></pagination>
    </div>
  </div>
</template>

<script>
import Pagination from './Pagination.vue'
import QuestionExcerpt from './QuestionExcerpt'

export default {
  name: 'Questions',
  data() {
    return {
      questions: [],
      links: {},
      meta: {},
    }
  },
  created() {
    this.fetchQuestions()
  },
  watch: {
	  "$route": "fetchQuestions"
  },
  components: {
    QuestionExcerpt,
    Pagination,
  },
  methods: {
    fetchQuestions() {
      axios.get('/questions', {params: this.$route.query}).then(({ data }) => {
        
        this.questions = data.data
        this.links = data.links
        this.meta = data.meta
      })
    },
    remove(id){
      this.questions.splice(id, 1)
      this.count--
    }
  },
}
</script>
