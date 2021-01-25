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
        <a
            v-if="accepted"
            title="this answer is best answer"
            :class="classes"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
import EventBus from '../event-bus'
export default {
    props: ['answer'],
    data() {
        return {
            isBest: this.answer.is_best,
            id: this.answer.id,
        }
    },
    created() {
        EventBus.$on('accepted', id => {
            this.isBest = id == this.id
        })
    },
    computed: {
        classes() {
            return ['answer', this.isBest ? 'answer-accepted' : '']
        },
        accepted() {
            return !this.canAccept && this.isBest
        },
        canAccept() {
            // console.log(this.answer);
            if(!this.isBest){
                return this.authorize('accept', this.answer)
            }
        },
    },
    methods: {
        create() {
            axios.post(`/answers/${this.id}/accept`).then(res => {
                this.$toast.success(res.data.message, 'Success', {
                    timeout: 3000,
                    position: 'bottomLeft',
                })

                EventBus.$emit('accepted', this.id)
            })
        },
    },
}
</script>
