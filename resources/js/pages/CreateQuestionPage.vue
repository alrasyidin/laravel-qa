<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h3 class="m-0">Ask Questions</h3>
            </div>
          </div>

          <div class="card-body">
            <question-form @submitted="create"></question-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import QuestionForm from '../components/QuestionForm'
import EventBus from '../event-bus'

export default {
  name: 'CreateQuestionPage',
  data() {
    return {}
  },
  components: {
    QuestionForm,
  },
  methods: {
    create(payload) {
      axios
        .post('/questions', payload)
        .then(response => {
          this.$toast.success(response.message, 'Success');
          this.$router.push({name: 'questions'})
        })
        .catch(({response}) => {
          console.log(response.data.errors);
          
          EventBus.$emit("error", response.data.errors);
        })
    },
  },
}
</script>

<style></style>
