<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h3 class="m-0">Edit Questions</h3>
            </div>
          </div>

          <div class="card-body">
            <question-form @submitted="update" :isEdit="true"></question-form>
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
  name: 'EditQuestionPage',
  data() {
    return {}
  },
  components: {
    QuestionForm,
  },
  methods: {
    update(payload) {
      axios
        .put(`/questions/${this.$route.params.id}`, payload)
        .then(({ data }) => {
          this.$router.push({ name: 'questions' })
          this.$toast.success(data.message, 'Success')
        })
        .catch(({response}) => {
          EventBus.$emit("error", response.data.errors);
        })
    },
  },
}
</script>

<style></style>
