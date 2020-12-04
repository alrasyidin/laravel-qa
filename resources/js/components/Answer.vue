<template>
  <div class="media post">
    <vote name="answer" :model="answer"></vote>

    <div class="media-body">
      <form v-if="editing" v-on:submit.prevent="update">
        <div class="form-group">
          <textarea rows="8" v-model="body" class="form-control"></textarea>
        </div>
        <button
          type="submit"
          class="btn btn-sm btn-primary"
          :disabled="isInvalid"
        >
          Update
        </button>
        <button class="btn btn-sm btn-secondary" @click.prevent="cancel">
          Cancel
        </button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              <a
                v-if="this.authorize('modify', answer)"
                @click.prevent="edit"
                class="btn btn-sm btn-outline-info"
              >
                Edit
              </a>
              <button
                v-if="this.authorize('modify', answer)"
                class="btn btn-sm btn-outline-danger"
                @click="destroy"
              >
                Delete
              </button>
            </div>
          </div>
          <div class="col-4"></div>
          <div class="col-4">
            <user-info :model="answer" label="Dijawab"></user-info>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from './Vote'
import UserInfo from './UserInfo'
import modification from '../mixins/modification'

export default {
  mixins: [modification],
  components: { Vote, UserInfo },
  props: ['answer'],
  data() {
    return {
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      beforeEditCacheState: null,
      questionId: this.answer.question_id,
      id: this.answer.id,
    }
  },
  methods: {
    setEditCache() {
      this.beforeEditCacheState = this.body
    },
    restoreFromCache() {
      this.body = this.beforeEditCacheState
    },
    payload() {
      return {
        body: this.body,
      }
    },
    delete() {
      axios
        .delete(this.endpoint)
        .then(({ data }) => {
          this.$emit('deleted', data.message)
        })
        .catch(({ response }) =>
          this.$toast.error(response.data.message, 'Error')
        )
    },
  },
  computed: {
    isInvalid() {
      return this.body.length < 10
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`
    },
  },
}
</script>
