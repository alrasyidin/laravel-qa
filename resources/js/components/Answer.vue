<script>
export default {
    props: ["answer"],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            beforeEditCacheState: null,
            questionId: this.answer.question_id,
            id: this.answer.id,
        };
    },
    methods: {
        update() {
            axios
                .patch(this.endpoint, {
                    body: this.body
                })
                .then(res => {
                    console.log(res);
                    let data = res.data;
                    this.bodyHtml = data.body_html;
                    this.editing = false;
                })
                .catch(err => console.log(err));
        },
        edit() {
            this.beforeEditCacheState = this.body;

            this.editing = true;
        },
        cancel() {
            this.body = this.beforeEditCacheState;

            this.editing = false;
        },
        destroy() {
          if(confirm('Are you sure?')){
            axios
                .delete(this.endpoint)
                .then(res => {
                  console.log(res)
                  $(this.$el).fadeOut(500, () => {
                    alert(res.data.message)
                  })
                })
                .catch(err => console.log(err.response));
          }
        }
    },
    computed: {
        isInvalid() {
            return this.body.length < 10;
        },
        endpoint(){
          return `/questions/${this.questionId}/answers/${this.id}`
        }
    }
};
</script>
