export default {
    data() {
        return {
            editing: false,
        }
    },
    methods: {
        edit() {
            this.setEditCache()
            this.editing = true
        },

        cancel() {
            this.restoreFromCache()

            this.editing = false
        },

        setEdtiCache() {},
        restoreFromCache() {},

        update() {
            axios
                .put(this.endpoint, this.payload())
                .then(({ data }) => {
                    this.bodyHtml = data.body_html

                    this.editing = false

                    this.$toast.success(data.message, 'Success')
                })
                .catch(({ resposne }) => {
                    this.$toast.error(response.data.message, 'error')
                })
        },
        payload() {},

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
                            this.delete()
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
        delete(){}
    },
}
