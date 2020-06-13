<template>
	<div id="app">
		<div class="container text-center mt-3">
			<h1>Welcome to Tempo Dump</h1>
		</div>
		<KeyStep v-model="tempoKeyEdit" v-if="!tempoKey"/>
		<!-- <img alt="Vue logo" src="./assets/logo.png">
		<HelloWorld msg="Welcome to Your Vue.js App"/> -->
	</div>
</template>

<script>
//import HelloWorld from './components/HelloWorld.vue'
import KeyStep from './components/KeyStep.vue'

export default {
	name: 'App',
	components: {
		// HelloWorld
		KeyStep
	},
	data() {
		return {
			tempoKey: ''
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
		}
	},
	created() {
		this.tempoKey = localStorage.getItem('tempoKey');
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
</style>
