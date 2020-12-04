<template>
    <div class="media post">
        <vote name="answer" :model="answer"></vote>

        <div class="media-body">
            <form v-if="editing" v-on:submit.prevent="update">
                <div class="form-group">
                    <textarea
                        rows="8"
                        v-model="body"
                        class="form-control"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="btn btn-sm btn-primary"
                    :disabled="isInvalid"
                >
                    Update
                </button>
                <button
                    class="btn btn-sm btn-secondary"
                    @click.prevent="cancel"
                >
                    Cancel
                </button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a
                                v-if="this.authorize('modify', answer)"
                                @click.prevent="edit"
                                class="btn btn-sm btn-outline-info"
                            >
                                Edit
                            </a>
                            <button
                                v-if="this.authorize('modify', answer)"
                                class="btn btn-sm btn-outline-danger"
                                @click="destroy"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Dijawab"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vote from './Vote'
import UserInfo from './UserInfo'

export default{
    components: { Vote, UserInfo },
    props: ['answer'],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            beforeEditCacheState: null,
            questionId: this.answer.question_id,
            id: this.answer.id,
        }
    },
    methods: {
        update() {
            axios
                .patch(this.endpoint, {
                    body: this.body,
                })
                .then(res => {
                    console.log(res)
                    let data = res.data
                    this.bodyHtml = data.body_html
                    this.editing = false

                    this.$toast.success(res.data.message, 'Success', {
                        timeout: 3000,
                    })
                })
                .catch(err => {
                    this.$toast.error(res.response.data.message, 'Error', {
                        timeout: 3000,
                    })
                })
        },
        edit() {
            this.beforeEditCacheState = this.body

            this.editing = true
        },
        cancel() {
            this.body = this.beforeEditCacheState

            this.editing = false
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
                buttons: [
                    [
                        '<button><b>YES</b></button>',
                        (instance, toast) => {
                            axios
                                .delete(this.endpoint)
                                .then(res => {
                                    this.$emit('deleted', res.data.message)
                                })
                                .catch(err => console.log(err.response))

                            instance.hide(
                                { transitionOut: 'fadeOut' },
                                toast,
                                'button'
                            )
                        },
                        true,
                    ],
                    [
                        '<button><b>NO</b></button>',
                        (instance, toast) => {
                            instance.hide(
                                { transitionOut: 'fadeOut' },
                                toast,
                                'button'
                            )
                        },
                    ],
                ],
            })
        },
    },
    computed: {
        isInvalid() {
            return this.body.length < 10
        },
        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`
        },
    },
}
</script>
