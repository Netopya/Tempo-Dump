<template>
	<div class="col">
		<label class="d-block">
			<input type="text" class="form-control" :class="{ 'is-invalid': timeError }" name="time[]" placeholder="Time spent" v-model="timeValue" @input="updateTimeSpent">
		</label>
	</div>
</template>


<script>
import renderTime from '../utilities/renderTime.js'

const TIME_SPENT_REGEX = /^\D*((?<hours>\d+)[hH])?\D*((?<minutes>\d+)\D*[mM])?\D*$/g;

function parseTime(time) {
	let result = TIME_SPENT_REGEX.exec(time);
	let timeSpent = 0;

	if (!result || (!result.groups.hours && !result.groups.minutes)) {
		return NaN;
	}

	if (result.groups.hours) {
		timeSpent += parseInt(result.groups.hours) * 3600
	}
	if (result.groups.minutes) {
		timeSpent += parseInt(result.groups.minutes) * 60
	}

	return timeSpent;
}

export default {
	name: 'TimeSpent',
	data() {
		return {
			timeError: false,
			timeValue: ''
		}
	},
	computed: {
	},
	created() {
		this.timeValue = renderTime(this.$attrs.value);
	},
	methods: {
		updateTimeSpent(event) {
			let value = event.target.value;
			let new_value = parseTime(value);
			let is_valid = !isNaN(new_value);

			if (is_valid) {
				this.$emit('input', new_value)
			}

			this.timeError = !is_valid && value;
		},
		refresh() {
			this.timeValue = renderTime(this.$attr.value);
		}
	},
	watch: {
		'$attrs.value': function(value) {
			this.timeValue = renderTime(value);
		}
	}
}
</script>