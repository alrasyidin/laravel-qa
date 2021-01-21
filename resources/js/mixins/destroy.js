export default {
	methods: {
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
	}
}