<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form class="card-body" v-show="authorize('modify', question) && editing" @submit.prevent="update">
          <div class="card-title">
            <input type="text" v-model="title" class="form-control" />
          </div>

          <div class="media">
            <editor :body="body" :name="uniqueName">
              <textarea
                v-model="body"
                class="form-control"
                rows="8"
                ref="textbox"
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
        <div class="card-body" v-show="!editing">
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h2 class="m-0 w-75">{{ title }}</h2>
              
              <router-link exact :to="{name: 'questions'}" class="btn btn-outline-secondary ml-auto">
                Back to all Question
              </router-link>
            </div>
          </div>

          <hr />

          <div class="media">
            <vote name="question" :model="question"></vote>

            <div class="media-body">
              <div v-html="bodyHtml" ref="bodyHtml"></div>
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto mt-2">
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
import highlight from '../mixins/highlight'
// import autosize from 'autosize'
// import highlight from 'highlight.js'

export default {
  props: ['question'],
  mixins: [modification, highlight],
  components: {
    Vote,
    UserInfo,
    Editor,
  },
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      id: this.question.id,
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
    delete () {
      axios
        .delete(this.endpoint)
        .then(({ data }) => {
          this.$toast.success(data.message, 'Success', { tiemout: 3000 })
          this.$router.push({name: 'questions'})
        })
        .catch(({ response }) =>
          this.$toast.error(response.data.message, 'Error')
        )
    },
  },
  computed: {
    isInvalid() {
      return this.title.length < 10 || this.body.length < 10
    },
    endpoint() {
      return `/questions/${this.question.id}`
    },
    uniqueName(){
      return `answer-${this.id}`
    }
  },
  // updated() {
  //   autosize(this.$refs.textbox)
  //   console.log('berhasil')
    
  //   highlight.highlightBlock(this.$refs.bodyHtml.querySelector('pre code'))
  // }
}
</script>
