<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form class="card-body" v-if="editing" @submit.prevent="update">
          <div class="card-title">
            <input
              type="text"
              v-model="title"
              class="form-control form-control-lg"
            />
          </div>

          <div class="media">
            <editor>
              <textarea
                v-model="body"
                class="form-control form-control-lg"
                rows="8"
              ></textarea>
            </editor>
          </div>
          <div class="form-group mt-4">
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
          </div>
        </form>
        <div class="card-body" v-else>
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h2 class="m-0 w-75">{{ title }}</h2>
              <a href="/questions" class="btn btn-outline-secondary ml-auto"
                >Back to all Question</a
              >
            </div>
          </div>

          <hr />

          <div class="media">
            <vote name="question" :model="question"></vote>

            <div class="media-body">
              <div v-html="bodyHtml"></div>
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    <a
                      v-if="this.authorize('modify', question)"
                      @click.prevent="edit"
                      class="btn btn-sm btn-outline-info"
                    >
                      Edit
                    </a>
                    <button
                      v-if="this.authorize('deleteQuestion', question)"
                      class="btn btn-sm btn-outline-danger"
                      @click="destroy"
                    >
                      Delete
                    </button>
                  </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                  <user-info :model="question" label="Ditanya"></user-info>
                </div>
              </div>
            </div>
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
export default {
  props: ['question'],
  mixins: [modification],
  components: {
    Vote,
    UserInfo,
    Editor
  },
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      beforeEditCacheState: {},
    }
  },
  methods: {
    setEditCache() {
      this.beforeEditCacheState.title = this.title
      this.beforeEditCacheState.body = this.body
    },
    restoreFromCache() {
      this.title = this.beforeEditCacheState.title
      this.body = this.beforeEditCacheState.body
    },
    payload() {
      return {
        title: this.title,
        body: this.body,
      }
    },
    delete() {
      axios
        .delete(this.endpoint)
        .then(({ data }) => {
          this.$toast.success(data.message, 'Success', { tiemout: 3000 })
        })
        .catch(({ response }) =>
          this.$toast.error(response.data.message, 'Error')
        )

      setTimeout(() => {
        window.location.href = '/questions'
      }, 4000)
    },
  },
  computed: {
    isInvalid() {
      return this.title.length < 10 || this.body.length < 10
    },
    endpoint() {
      return `/questions/${this.question.id}`
    },
  },
}
</script>
