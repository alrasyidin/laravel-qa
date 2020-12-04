<template>
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h3>Your answer</h3>
          </div>
          <hr>
          <form @submit.prevent="create">
            <div class="form-group">
              <textarea class="form-control" v-model="body" name="body" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" :disabled="isInvalid" class="btn btn-outline-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['questionId'],
  data(){
    return {
      body: ''
    }
  },
  computed: {
    isInvalid(){
      return !this.signedIn || this.body.length < 10
    }
  },
  methods: {
    create(){
      axios.post(`/questions/${this.questionId}/answers`, {
        body: this.body
      })
      .then(({data}) => {
        this.body = ''

        this.$emit('created', data.answer)
        
        this.$toast.success(data.message, 'Success')
      })
      .catch((error) => {
        this.$toast.error(error.response.data.message, 'Error')
      })
    }
  }
}
</script>