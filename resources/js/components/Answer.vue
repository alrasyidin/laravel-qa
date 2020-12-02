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

                    this.$toast.success(res.data.message, 'Success', { timeout: 3000})
                })
                .catch(err => {
                    this.$toast.error(res.response.data.message, 'Error', { timeout: 3000})
                });
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
            this.$toast.question('Are you sure about that?', 'Confirm', {
              timeout: 3000,
              close: false,
              overlay: true,
              displayMode: 'once',
              id: 'question',
              zindex: 999,
              title: 'Hey',
              position: 'center',
              buttons:[
                [
                  '<button><b>YES</b></button>',
                  (instance, toast) => {
                    axios
                        .delete(this.endpoint)
                        .then(res => {
                          console.log(res)
                          $(this.$el).fadeOut(500, () => {
                            this.$toast.success(res.data.message, 'Success', {timeout: 3000})
                          })
                        })
                        .catch(err => console.log(err.response));

                    instance.hide({transitionOut: 'fadeOut'}, toast, 'button')
                  },
                  true
                ],
                [
                  '<button><b>NO</b></button>',
                  (instance, toast) => {
                    instance.hide({transitionOut: 'fadeOut'}, toast, 'button')
                  }
                ]
              ] 
            })
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
