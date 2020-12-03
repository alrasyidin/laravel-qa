<template>
    <div>
        <a
            v-if="canAccept"
            title="Click to mark as best answer"
            :class="classes"
            @click.prevent="create"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-if="accepted" title="Click to mark as best answer" :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
export default {
    props: ['answer'],
    data() {
        return {
            isBest: this.answer.is_best,
            id: this.answer.id,
        }
    },
    computed: {
        classes() {
            return ['answer', this.isBest ? 'answer-accepted': '']
        },
        accepted() {
            return !this.canAccept && this.isBest
        },
        canAccept() {
            return this.authorize('accept', this.answer)
        },
    },
    methods: {
        create() {
            axios.post(`/answer/${this.id}/accept`).then(res => {
                this.$toast.success(res.data.message, 'Success', {
                    timeout: 3000,
                    position: 'bottomLeft',
                })

                this.isBest = true
            })
        },
    },
}
</script>
