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

      <div v-if="errors['title'][0]" class="invalid-feedback">
        <strong>{{ errors['title'][0] }}</strong>
      </div>
    </div>

    <div class="form-group">
      <label for="question-body">Explain your question</label>
      <textarea
        name="body"
        :class="errorClass('body')"
        v-model="body"
        rows="10"
      ></textarea>

      <div v-if="errors['body'][0]" class="invalid-feedback">
        <strong>{{ errors['body'][0] }}</strong>
      </div>
    </div>

    <div class="form-group">
      <button class="btn btn-primary btn-large">{{ buttonText }}</button>
    </div>
  </form>
</template>

<script>
export default {
  name: 'QuestionForm',
  data() {
    return {
      title: '',
      body: '',
      errors: {
        title: '',
        body: '',
      },
    }
  },
  computed: {
	  buttonText(){
		  return "Ask Question"
	  }
  },
  methods: {
    handleSubmit() {
		this.$emit("submitted", {
			title: this.title,
			body: this.body
		});
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
