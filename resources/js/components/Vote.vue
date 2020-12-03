<template>
    <div class="d-flex flex-column align-items-center vote-control">
        <a :title="title('up')" class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a :title="title('down')" class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name == 'question'" :question="model"></favorite>

        <accept v-else :answer="model"></accept>
    </div>
</template>

<script>
import Favorite from './Favorite'
import Accept from './Accept'

export default {
    props: ['model', 'name'],
    components: {
      Favorite, 
      Accept
    },
    data() {
        return {
            count: this.model.votes_count,
        }
    },
    computed: {
        classes() {
            return this.signedIn ? '' : 'off'
        },
    },
    methods: {
        title(voteType) {
            const titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`,
            }
            return titles[voteType]
        },
    },
}
</script>
