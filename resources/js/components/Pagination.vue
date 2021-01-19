<template>
  <div class="row align-items-center">
    <div class="col">
      <button
        :disabled="isFirst"
        type="button"
        @click="olderPost()"
        class="btn btn-outline-secondary"
      >
        Older
      </button>
    </div>
    <div class="col text-center">
      {{ pageInfo }}
    </div>
    <div class="col text-right">
      <button
        :disabled="isLast"
        @click="newerPost()"
        type="button"
        class="btn btn-outline-secondary"
      >
        Newer
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  props: ['links', 'meta'],
  methods: {
    olderPost() {
      if (!this.isFirst) {
        this.meta.current_page--
      }
      this.switchPage()
    },
    newerPost() {
      if (!this.isLast) {
        this.meta.current_page++
      }
      this.switchPage()
    },
    switchPage() {
	  console.log(this.$router)
	  console.log(this.$route)
      this.$router.push({
        name: 'questions',
        query: {
          page: this.meta.current_page,
        },
      })
    },
  },
  computed: {
    isFirst() {
      return this.meta.current_page === 1
    },
    isLast() {
      return this.meta.current_page === this.meta.last_page
    },
    pageInfo() {
      return `Page ${this.meta.current_page} of ${this.meta.last_page}`
    },
  },
}
</script>
