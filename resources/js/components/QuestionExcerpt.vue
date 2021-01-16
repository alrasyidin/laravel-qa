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
        <a href="#" class="w-75">
          <h4>{{ question.title }}</h4>
        </a>
        <div class="ml-auto">
          <a
            href="#"
            class="btn btn-sm btn-outline-info"
            v-if="authorize('modify', question)"
            >Edit</a
          >
          <form
            v-if="authorize('deleteQuestion', question)"
            action="#"
            method="post"
            class="d-inline-block"
          >
            <button
              class="btn btn-sm btn-outline-danger"
              onclick="return confirm('Are you sure delete this question?');"
              type="submit"
            >
              Delete
            </button>
          </form>
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
export default {
  name: 'QuestionExcerpt',
  props: ['question'],
  methods: {
    str_plural(str, count) {
      return str + (count > 1) ? 's' : ''
    },
  },
  computed: {
    statusClass() {
      return ['status', this.question.status]
    },
  },
}
</script>
