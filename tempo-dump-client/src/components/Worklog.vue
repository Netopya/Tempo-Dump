<template>
	<div class="row">
		<div class="col">
			<label class="d-block">
				<input type="text" class="form-control" name="ticket[]" placeholder="Ticket Key" v-model="worklog.issue">
			</label>
			<div><img v-if="icon" :src="icon"/> {{ title }}</div>
		</div>
		<div class="col">
			<label class="d-block">
				<input type="text" class="form-control" name="time[]" placeholder="Time spent" v-model="timeSpent">
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

const TIME_SPENT_REGEX = /^\D*((?<hours>\d+)[hH])?\D*((?<minutes>\d+)\D*[mM])?\D*$/g;

export default {
	name: 'Worklog',
	data() {
		return {
			title: '',
			icon: ''
		};
	},
	props: {
		activities: Array,
		jiraKey: String,
		email: String,
		worklog: Object
	},
	computed: {
		timeSpent: {
			get() {
				let seconds = this.worklog.seconds;
				if (isNaN(seconds)) {
					return '';
				}

				let h = Math.floor(seconds / 3600);
				let m = Math.floor(seconds % 3600 / 60);

				let output = '';

				if (h) {
					output += h + 'h';
				}

				if (m) {
					output += m + 'm';
				}

				return output;
			},
			set(value) {
				let result = TIME_SPENT_REGEX.exec(value);
				let timeSpent = 0;

				if (!result) {
					return;
				}

				if (result.groups.hours) {
					timeSpent += parseInt(result.groups.hours) * 3600
				}
				if (result.groups.minutes) {
					timeSpent += parseInt(result.groups.minutes) * 60
				}

				this.worklog.seconds = timeSpent;
			}
		}
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