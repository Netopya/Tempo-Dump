<template>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<form class="col-6 text-center" @submit.prevent="save">
				<input type="text" class="form-control mb-3" placeholder="Tempo Key" :value="value" @input="tempoKey = $event.target.value"/>
				<button class="btn btn-success btn-lg">Save</button>
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'KeyStep',
	data() {
		return {
			tempoKey: ''
		}
	},
	props: {
		value: String
	},
	methods: {
		save() {
			this.$emit('input', this.tempoKey)
		}
	}
}
</script>