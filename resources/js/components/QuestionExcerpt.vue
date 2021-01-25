<template>
  <div class="media post">
    <div class="d-flex flex-column counters">
      <div class="vote">
        <strong>{{ question.votes_count }}</strong>
        {{ str_plural('vote', question.votes_count) }}
      </div>
      <div :class="statusClass">
        <strong>{{ question.answers_count }}</strong>
        {{ str_plural('answer', question.answers_count) }}
      </div>
      <div class="view">
        {{ question.views + ' ' + str_plural('view', question.views) }}
      </div>
    </div>
    <div class="media-body">
      <div class="d-flex align-items-center">
        <router-link class="w-75" :to="{name: 'question', params: {slug: question.slug}}"> <h4>{{ question.title }}</h4></router-link>
        <div class="ml-auto">
          <router-link
            class="btn btn-sm btn-outline-info"
            v-if="authorize('modify', question)"
            :to="{ name: 'questions.edit', params: { id: question.id } }"
            >Edit</router-link
          >
          <button
            v-if="authorize('deleteQuestion', question)"
            @click="destroy"
            class="btn btn-sm btn-outline-danger"
          >
            Delete
          </button>
        </div>
      </div>
      <p class="lead">
        Asked By
        <a href="#">{{ question.user.name }}</a>
        <small class="text-muted">{{ question.created_date }}</small>
      </p>
      {{ question.excerpt }}
    </div>
  </div>
</template>

<script>
import destroy from '../mixins/destroy'
import highlight from '../mixins/highlight'

export default {
  name: 'QuestionExcerpt',
  props: ['question'],
  mixins: [destroy],
  methods: {
    str_plural(str, count) {
      let s = count != 1 || count != 0 ? 's' : ''

      return str + s
    },
    delete() {
      axios
        .delete(`questions/${this.question.id}`)
        .then(({ data }) => {
          this.$toast.success(data.message, 'Success', { timeout: 2000 })
          this.$emit('deleted')
        })
        .catch(({ response }) => {
          console.log(response.data.message)
          // this.$toast.error(response.data.message, 'Success', { timeout: 2000 })
        })
    },
  },
  computed: {
    statusClass() {
      return ['status', this.question.status]
    },
  },
}
</script>
