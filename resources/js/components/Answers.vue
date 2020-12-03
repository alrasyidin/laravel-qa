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
                        v-for="answer in answers"
                        :key="answer.id"
                        :answer="answer"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Answer from './Answer.vue'

export default {
    props: ['answers', 'count'],
    components: { Answer },
    data() {
        return {}
    },
    computed: {
        headCount() {
          return `${this.count} ${this.count > 0 ? 'Answers' : 'Answer'}`
        },
    },
}
</script>
