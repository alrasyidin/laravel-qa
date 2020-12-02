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
            id: this.answer.id
        };
    },
    methods: {
        update() {
            axios
                .patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                .then((res) => {
                    console.log(res);
                    let data = res.data
                    this.bodyHtml = data.body_html
                    this.editing = false
                })
                .catch(err => console.log(err));
        },
        edit(){
          this.beforeEditCacheState = this.body 
          
          this.editing = true
        },
        cancel(){
          this.body =  this.beforeEditCacheState

          this.editing = false
        }
    },
    computed: {
      isInvalid(){
        return this.body.length < 10
      }
    }
};
</script>
