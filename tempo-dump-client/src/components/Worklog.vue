<template>
	<div class="row">
		<div class="col">
			<label class="d-block">
				<input type="text" class="form-control" name="ticket[]" placeholder="Ticket Key" v-model="worklog.issue">
			</label>
			<div><img v-if="icon" :src="icon"/> {{ title }}</div>
		</div>
		<TimeSpent v-model="worklog.seconds"/>
		<div class="col">
			<label class="d-block">
				<select class="form-control" v-model="worklog.activity">
					<option v-for="activity in activities" :key="activity" :value="activity">{{ activity }}</option>
				</select>
			</label>
		</div>
		<div class="col">
			<label class="d-block">
				<textarea type="text" class="form-control" name="description[]" placeholder="Description" rows="3" v-model="worklog.description"></textarea>
			</label>
		</div>
	</div>
</template>

<script>
import _ from 'lodash'
import axios from 'axios'
import TimeSpent from './TimeSpent.vue'

export default {
	name: 'Worklog',
	components: {
		TimeSpent
	},
	data() {
		return {
			title: '',
			icon: '',
		};
	},
	props: {
		activities: Array,
		jiraKey: String,
		email: String,
		worklog: Object
	},
	computed: {
	},
	created() {
		this.deboucedJiraUpdate = _.throttle(this.updateJiraTicket, 1000);
		this.worklog.activity = this.activities[0];
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
			params.append('issue', this.worklog.issue);
			params.append('email', this.email);
			axios.post('http://www.netopyaplanet.com/tempodump/issue.php', params)
				.then((resp) => {
					console.log(resp.data);

					const data = resp.data;

					try {
						this.title = data.fields.summary;
					} catch(ex) {
						this.title = '';
					}

					try {
						this.icon = data.fields.issuetype.iconUrl;
					} catch(ex) {
						this.icon = '';
					}
				});
		}
	},
	watch: {
		'worklog.issue': function(value) {
			this.worklog.issue = value.toUpperCase();
			this.worklog.empty = !value;
			this.deboucedJiraUpdate();
		}
	}
	// watch: {
	// 	worklog: {
	// 		hander(value) {
	// 			this.$emit('input', value);
	// 		},
	// 		deep: true
	// 	}
	// }
}
</script>