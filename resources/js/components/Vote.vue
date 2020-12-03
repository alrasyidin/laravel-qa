<template>
    <div class="d-flex flex-column align-items-center vote-control">
        <a @click="voteUp" :title="title('up')" class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a @click="voteDown" :title="title('down')" class="vote-down" :class="classes">
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
        endpoint(){
          return `/${this.name}s/${this.model.id}/vote`
        }
    },
    methods: {
        title(voteType) {
            const titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`,
            }
            return titles[voteType]
        },
        voteUp(){
          this._vote(1)
        },
        voteDown(){
          this._vote(-1)
        },
        _vote(vote){
          if(!this.signedIn){
            this.$toast.warning(`Please login to vote this ${this.name}`)
            return
          }

          axios.post(this.endpoint, { vote })
          .then(({data}) => {
            this.$toast.success(data.message, 'Success', {
              timeout: 3000,
              position: 'bottomLeft'
            })

            this.count = data.votesCount
          })
        }
    },
}
</script>
