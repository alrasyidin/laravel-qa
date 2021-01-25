<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card text-center">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <router-link class="nav-link" exact :to="{name: 'my-posts'}"> All</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" exact :to="{name: 'my-posts', query: {type: 'questions'}}"> Querstions</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" exact :to="{name: 'my-posts', query: {type: 'answers'}}"> Answers</router-link>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush" v-if="posts.length">
              <li class="list-group-item" v-for="(post, index) in posts" :key="index">
                <div class="row">
                  <div class="col">
                    <span class="post-badge" :class="statusClass">{{post.type}}</span>
                    <span class="ml-4 votes-count" :class="statusClass">{{post.votes_count}}</span>
                  </div>
                  <div class="col-md-9 text-left">{{post.title}}</div>
                  <div class="col text-right">
                    {{ post.created_at }}
                  </div>
                </div>
              </li>
            </ul>
            <div class="alert alert-warning" v-else>
              <p>You have no any questions or answers</p>
              <p>
                <router-link :to="{ name: 'questions.create' }">Ask Question</router-link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MyPostsPage",
  data(){
    return {
      posts: []
    }
  },
  mounted(){
    this.fetchPosts()
  },
  computed: {
    statusClass(){
      return [
        this.posts.accepted ? 'accepted' : ''
      ]
    }
  },  
  methods: {
    fetchPosts(){
      axios.get('my-posts', {params: this.$route.query})
      .then(({data}) => {
        this.posts = data.data
      })
      .catch(({response}) => {
        console.log(response)
      })
    }
  },
  watch:{
    "$route": "fetchPosts"
  }
}
</script>

<style lang="sass" scoped>
  $color-green: rgba(95, 187, 126)
  
  .votes-count, .post-badge
    text-align: center
    color: $color-green
    display: inline-block

  .votes-count
    border: 1px solid #ddd
    min-width: 40px
    
    &.accepted
      border: 1px solid $color-green
      background: $color-green
      color: white
  
  .post-badge
    border: 1px solid #ddd
    width: 25px
    border-radius: 100%

    &.accepted
      border: 1px solid $color-green
      color: $color-green
    
</style>