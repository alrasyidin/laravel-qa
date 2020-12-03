<template>
    <a
        href=""
        title="Click to mark as favorite question"
        :class="classes"
        @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorite-count"
            ><strong>{{ count }}</strong></span
        >
    </a>
</template>

<script>
export default {
    props: ['question'],
    data() {
        return {
            id: this.question.id,
            count: this.question.favorites_count,
            isFavorited: this.question.is_favorited,
        }
    },
    methods: {
        toggle() {
            if (!this.signedIn) {
                this.$toast.warning(
                    'You must login to favorite this question',
                    'Warning',
                    {
                        timeout: 3000,
                        position: 'bottomLeft',
                    }
                )
                return
            }
            this.isFavorited ? this.destroy() : this.create()
        },
        create() {
            axios.post(this.endpoint).then(res => {
                this.count++
                this.isFavorited = true
            })
        },
        destroy() {
            axios.delete(this.endpoint).then(res => {
                this.count--
                this.isFavorited = false
            })
        },
    },
    computed: {
        classes() {
            return [
                !this.signedIn ? 'off' : this.isFavorited ? 'favorited' : '',
            ]
        },
        endpoint() {
            return `/questions/${this.id}/favorite`
        },
    },
}
</script>
