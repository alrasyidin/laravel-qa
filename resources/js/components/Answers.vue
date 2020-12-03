<template>
    <div class="row mt-5" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ headCount }}</h2>
                    </div>
                    <hr />
                    <answer
                        @deleted="remove(index, $event)"
                        v-for="(answer, index) in answers"
                        :key="answer.id"
                        :answer="answer"
                    />

                    <div
                        class="d-flex justify-content-center align-items-center py-4"
                        v-if="nextUrl"
                    >
                        <button
                            @click.prevent="fetch(nextUrl)"
                            class="btn btn-outline-secondary"
                        >
                            Load more answers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Answer from './Answer.vue'

export default {
    props: ['question'],
    components: { Answer },
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null,
        }
    },
    created() {
        this.fetch(`/questions/${this.questionId}/answers`)
    },
    computed: {
        headCount() {
            return `${this.count} ${this.count > 0 ? 'Answers' : 'Answer'}`
        },
    },
    methods: {
        fetch(endpoint) {
            axios.get(endpoint).then(({ data }) => {
                this.answers.push(...data.data)

                if (data.next_page_url) {
                    let url = new URL(data.next_page_url)
                    this.nextUrl = `${url.pathname}/${url.search}`
                } else {
                    this.nextUrl = null
                }
            })
        },
        remove(index, event) {
            this.answers.splice(index, 1)
            this.count--
            this.$toast.success(event, 'Success', { timeout: 3000 })
        },
    },
}
</script>
