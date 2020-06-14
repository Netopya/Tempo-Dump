<template>
	<div class="container mt-5">
		<h2>Select the activities you would like to use</h2>
		<p>
			Do timesheets have activities you rarely use? Uncheck them here to trim down on time selecting log activites.
		</p>
		<form @submit.prevent="save">
			<label class="form-check" v-for="activity in activities" :key="activity">
				<input type="checkbox" class="form-check-input" :value="activity" name="activities" v-model="selectedActivities">
				<span class="form-check-label">{{ activity }}</span>
			</label>
			<button class="btn btn-success btn-lg mt-3">Save</button>
		</form>
	</div>
</template>

<script>
import axios from 'axios'

export default {
	name: 'ActivitiesSelector',
	data() {
		return {
			activities: [],
			selectedActivities: []
		};
	},
	props: {
		tempoKey: String,
		value: Array
	},
	created() {
		if (!this.tempoKey) return;

		let params = new URLSearchParams();
		params.append('auth_key', this.tempoKey);
		axios.post('http://www.netopyaplanet.com/tempodump/work-attributes.php', params)
			.then((resp) => {
				console.log(resp.data);
				this.activities = resp.data.results[0].values;
				this.selectedActivities = this.value && this.value.length ? this.value : this.activities;
			});
	},
	methods: {
		save() {
			this.$emit('input', this.selectedActivities)
		}
	}
}
</script>