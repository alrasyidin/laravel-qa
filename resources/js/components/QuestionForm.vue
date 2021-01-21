<template>
  <form @submit.prevent="handleSubmit">
    <div class="form-group">
      <label for="question-title">Question Title</label>
      <input
        type="text"
        name="title"
        v-model="title"
        :class="errorClass('title')"
      />

      <div v-if="errors.title" class="invalid-feedback">
        <strong>{{ errors.title[0] }}</strong>
      </div>
    </div>

    <div class="form-group">
      <label for="question-body">Explain your question</label>
      <editor :body="body" name="question-body">
        <textarea
          name="body"
          :class="errorClass('body')"
          v-model="body"
          rows="10"
        ></textarea>

        <div v-if="errors.body" class="invalid-feedback">
          <strong>{{ errors.body[0] }}</strong>
        </div>
      </editor>
    </div>

    <div class="form-group">
      <button class="btn btn-primary btn-large">{{ buttonText }}</button>
    </div>
  </form>
</template>

<script>
import EventBus from '../event-bus'
import Editor from './Editor'

export default {
  name: 'QuestionForm',
  data() {
    return {
      title: '',
      body: '',
      errors: {
        title: [],
        body: [],
      },
    }
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false  
    }
  },
  components: {
    Editor
  },
  mounted() {
    EventBus.$on('error', errors => (this.errors = errors))

    if (this.isEdit) {
      this.fetchQuestion();
    }
  },
  computed: {
    buttonText() {
      return this.isEdit ? 'Edit Question' : 'Ask Question'  
    },
  },
  methods: {
    fetchQuestion(){
      axios.get(`questions/${this.$route.params.id}`)
           .then(({data}) => {
             this.title = data.title
             this.body = data.body
           })
           .catch(error => console.log(error.response))
    },
    handleSubmit() {
      this.$emit('submitted', {
        title: this.title,
        body: this.body,
      })
    },
    errorClass(column) {
      return [
        'form-control',
        this.errors[column] && this.errors[column][0] ? 'is-invalid' : '',
      ]
    },
  },
}
</script>

<style></style>
