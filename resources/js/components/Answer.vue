<template>
  <div class="media post">
    <vote name="answer" :model="answer"></vote>

    <div class="media-body">
      <form v-show="authorize('modify', answer) && editing" v-on:submit.prevent="update">
        <div class="form-group">
          <editor :body="body" :name="uniqueName">
            <textarea rows="8" v-model="body" class="form-control" ref="textbox"></textarea>
          </editor>
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

      <div v-show="!editing">
        <div v-html="bodyHtml" ref="bodyHtml"></div>
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
import Editor from './Editor'
import modification from '../mixins/modification'

import highlight from '../mixins/highlight'
import autosize from 'autosize'

export default {
  mixins: [modification, highlight],
  components: { Vote, UserInfo, Editor },
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

    uniqueName(){
      return `answer-${this.id}`
    }
  },
}
</script>
