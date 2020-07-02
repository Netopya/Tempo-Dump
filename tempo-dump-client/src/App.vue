<template>
	<div id="app">
		<div class="container text-center mt-3">
			<h1>Welcome to Tempo Dump</h1>
		</div>
		<transition name="fade-scroll">
			<KeyStep v-model="tempoKeyEdit" keyName="Tempo Key" v-if="!tempoKey"/>
		</transition>
		<transition name="fade-scroll">
			<KeyStep v-model="jiraEmailEdit" keyName="Jira Email" v-if="tempoKey && !jiraEmail"/>
		</transition>
		<transition name="fade-scroll">
			<KeyStep v-model="jiraKeyEdit" keyName="Jira Key" v-if="tempoKey && jiraEmail && !jiraKey"/>
		</transition>
		<transition name="fade-scroll">
			<ActivitiesSelector :tempoKey="tempoKey" v-if="tempoKey && jiraEmail && jiraKey && !selectedActivities.length" v-model="selectedActivitiesEdit"/>
		</transition>
		<!-- <img alt="Vue logo" src="./assets/logo.png">
		<HelloWorld msg="Welcome to Your Vue.js App"/> -->

		<transition name="fade-scroll">
			<div class="container mt-5" v-if="tempoKey && jiraEmail && jiraKey && selectedActivities.length">
				<form>
					<transition-group name="fade-scroll-up" tag="p">
						<Worklog v-for="(worklog, index) in worklogs"
							:key="index"
							:activities="selectedActivities"
							:jiraKey="jiraKey"
							:email="jiraEmail"
							:worklog="worklog"/>
					</transition-group>
				</form>
			</div>
		</transition>
	</div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import KeyStep from './components/KeyStep.vue'
import ActivitiesSelector from './components/ActivitiesSelector.vue'
import Worklog from './components/Worklog.vue'

export default {
	name: 'App',
	components: {
		// HelloWorld
		KeyStep,
		ActivitiesSelector,
		Worklog
	},
	data() {
		return {
			tempoKey: '',
			jiraKey: '',
			jiraEmail: '',
			selectedActivities: [],
			worklogs: [{
				issue: '',
				empty: true,
				seconds: 0
			}]
		};
	},
	computed: {
		tempoKeyEdit: {
			get() {
				return this.tempoKey;
			},
			set(value) {
				if (!value) return;

				try {
					localStorage.setItem('tempoKey', value);
					this.tempoKey = value;
				} catch(exception) {
					alert('Failed to save tempo key');
				}
			}
		},
		selectedActivitiesEdit: {
			get() {
				return this.selectedActivities;
			},
			set(value) {
				try {
					localStorage.setItem('selectedActivities', JSON.stringify(value));
					this.selectedActivities = value;
				} catch(exception) {
					alert('Failed to save attribute preferences');
				}
			}
		},
		jiraEmailEdit: {
			get() {
				return this.jiraEmail;
			},
			set(value) {
				try {
					localStorage.setItem('jiraEmail', value);
					this.jiraEmail = value;
				} catch(exception) {
					alert('Failed to save Jira Email');
				}
			}
		},
		jiraKeyEdit: {
			get() {
				return this.jiraKey;
			},
			set(value) {
				try {
					localStorage.setItem('jiraKey', value);
					this.jiraKey = value;
				} catch(exception) {
					alert('Failed to save Jira Key');
				}
			}
		}
	},
	created() {
		this.tempoKey = localStorage.getItem('tempoKey');

		let attributes_store = localStorage.getItem('selectedActivities');
		this.selectedActivities = attributes_store ? JSON.parse(attributes_store) : [];

		this.jiraKey = localStorage.getItem('jiraKey');
		this.jiraEmail = localStorage.getItem('jiraEmail');
	},
	methods: {
		createTimelog() {
			this.worklogs.push({
				issue: '',
				empty: true,
				seconds: 0
			})
		}
	},
	watch: {
		worklogs: {
			handler() {
				if (!this.worklogs.length) {
					return;
				}

				if (!this.worklogs[this.worklogs.length - 1].empty) {
					this.createTimelog();
					this.$nextTick(() => {
						setTimeout(() => {
							this.$el.scrollIntoView({ behavior: 'smooth', block: 'end' });
						}, 100);
					});
				}
			},
			deep: true
		}
	}
}
</script>

<style>

#app {
	/* font-family: Avenir, Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
	margin-top: 60px; */
}

.fade-scroll-enter-active {
	animation: slide-in .5s;
}
.fade-scroll-leave-active {
	animation: slide-out .5s;
}

.fade-scroll-up-enter-active {
	animation: slide-up .5s;
}

@keyframes slide-in {
	from {
		transform: translateX(50px);
		opacity: 0;
	}
	to {
		transform: translateX(0);
		opacity: 1;
	}
}

@keyframes slide-out {
	from {
		transform: translateX(0);
		opacity: 1;
	}
	to {
		transform: translateX(-50px);
		opacity: 0;
	}
}

@keyframes slide-up {
	from {
		transform: translateY(40px);
		opacity: 0;
	}
	to {
		transform: translateY(0);
		opacity: 1;
	}
}
</style>
