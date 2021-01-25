<template>
  <div class="container" v-if="question">
    <question :question="question"></question>

    <answers :question="question"></answers>
  </div>
</template>

<script>
import Answers from '../components/Answers'
import Question from '../components/Question'
import EventBus from '../event-bus'

export default {
  props: ['slug'],
  components: {
    Question,
    Answers,
  },
  data(){
    return {
      question: null
    }
  },
  mounted(){
    this.fetchQuestion()
    
    EventBus.$on("answers-count-changed", count => {
      this.question.answers_count = count
    })
  },
  methods: {
    fetchQuestion(){
      axios.get(`questions/${this.slug}`)
          .then(({data}) => {
            console.log(data)
            this.question = data.data
          })
          .catch(error => console.log(error))
    }
  }
}
</script>