import destroy from './destroy'

export default {
    mixins: [destroy],
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
    },
}
