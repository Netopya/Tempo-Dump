<template>
	<div id="app">
		<div class="container text-center mt-3">
			<h1>Welcome to Tempo Dump</h1>
		</div>
		<transition name="fade-scroll">
			<KeyStep v-model="tempoKeyEdit" v-if="!tempoKey"/>
		</transition>
		<transition name="fade-scroll">
			<ActivitiesSelector :tempoKey="tempoKey" v-if="tempoKey && !selectedActivities.length" v-model="selectedActivitiesEdit"/>
		</transition>
		<!-- <img alt="Vue logo" src="./assets/logo.png">
		<HelloWorld msg="Welcome to Your Vue.js App"/> -->
	</div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import KeyStep from './components/KeyStep.vue'
import ActivitiesSelector from './components/ActivitiesSelector.vue'

export default {
	name: 'App',
	components: {
		// HelloWorld
		KeyStep,
		ActivitiesSelector
	},
	data() {
		return {
			tempoKey: '',
			selectedActivities: []
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
		}
	},
	created() {
		this.tempoKey = localStorage.getItem('tempoKey');

		let attributes_store = localStorage.getItem('selectedActivities');
		this.selectedActivities = attributes_store ? JSON.parse(attributes_store) : [];
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
</style>
