<template>
	<div class="row">
		<div class="col">
			<label class="d-block">
				<input type="text" class="form-control" name="ticket[]" placeholder="Ticket Key" v-model="ticketKey">
			</label>
		</div>
		<div class="col">
			<label class="d-block">
				<input type="text" class="form-control" name="time[]" placeholder="Time spent">
			</label>
		</div>
		<div class="col">
			<label class="d-block">
				<select class="form-control">
					<option v-for="activity in activities" :key="activity" :value="activity">{{ activity }}</option>
				</select>
			</label>
		</div>
		<div class="col">
			<label class="d-block">
				<textarea type="text" class="form-control" name="description[]" placeholder="Description" rows="3"></textarea>
			</label>
		</div>
	</div>
</template>

<script>
import _ from 'lodash'
import axios from 'axios'

export default {
	name: 'Worklog',
	data() {
		return {
			ticketKey: ''
		};
	},
	props: {
		activities: Array,
		jiraKey: String,
		email: String
	},
	created() {
		this.deboucedJiraUpdate = _.throttle(this.updateJiraTicket, 1000);
	},
	methods: {
		updateJiraTicket() {
			// let params = new URLSearchParams();
			// params.append('Authorization', `Basic: ${this.jiraKey}`);
			// axios.post('https://diffagency.atlassian.net/rest/api/3/issue/FOX-1', params)
			// 	.then((resp) => {
			// 		console.log(resp.data);
			// 	});

			let params = new URLSearchParams();
			params.append('auth_key', this.jiraKey);
			params.append('issue', 'FOX-1');
			params.append('email', this.email);
			axios.post('http://www.netopyaplanet.com/tempodump/issue.php', params)
				.then((resp) => {
					console.log(resp.data);
				});
		}
	}
}
</script>