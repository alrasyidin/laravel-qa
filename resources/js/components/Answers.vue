<template>
  <div>
    <div class="row mt-5" v-cloak v-if="count">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <h2>{{ headCount }}</h2>
            </div>
            <hr />
            <answer
              @deleted="remove(index, $event)"
              v-for="(answer, index) in answers"
              :key="index"
              :answer="answer"
            />

            <div
              class="d-flex justify-content-center align-items-center py-4"
              v-if="nextUrl"
            >
              <button
                @click.prevent="fetch(theNextUrl)"
                class="btn btn-outline-secondary"
              >
                Load more answers
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <new-answer @created="add" :question-id="question.id" />
  </div>
</template>

<script>
import EventBus from '../event-bus'
import Answer from './Answer.vue'
import NewAnswer from './NewAnswer.vue'

export default {
  props: ['question'],
  components: { Answer, NewAnswer },
  data() {
    return {
      questionId: this.question.id,
      count: this.question.answers_count,
      answers: [],
      nextUrl: null,
      excludeAnswers: [],
    }
  },
  created() {
    this.fetch(`/questions/${this.questionId}/answers`)
  },
  computed: {
    headCount() {
      return `${this.count} ${this.count > 0 ? 'Answers' : 'Answer'}`
    },
    theNextUrl() {
      if (this.nextUrl && this.excludeAnswers.length) {
        return this.nextUrl + this.excludeAnswers.map(answerId => "&excludes[]=" + answerId).join('')
      }
      return this.nextUrl;
    },
  },
  methods: {
    fetch(endpoint) {
      axios.get(endpoint).then(({ data }) => {
        this.answers.push(...data.data)
        console.log(data)
        this.nextUrl = data.links.next
      })
    },
    remove(index, event) {
      this.answers.splice(index, 1)
      this.count--
      this.$toast.success(event, 'Success', { timeout: 3000 })

      if (this.count === 0) {
        EventBus.$emit('answers-count-changed', this.count)
      }
    },
    add(answer) {
      //   exclude answer on the next page
      this.excludeAnswers.push(answer.id)

      this.answers.push(answer)
      this.count++

      if (this.count === 1) {
        EventBus.$emit('answers-count-changed', this.count)
      }
    },
  },
}
</script>
