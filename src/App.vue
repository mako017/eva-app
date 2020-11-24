<template>
	<div id="app">
		<AdminArea v-if="admin" />
		<Main v-else />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Main from "./components/Main.vue";
import AdminArea from "./components/AdminArea.vue";

@Component({
	components: {
		Main,
		AdminArea,
	},
})
export default class App extends Vue {
	private admin = true;
}
</script>

<style lang="scss">
#app {
	font-family: Avenir, Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
	padding-top: 0.4rem;
}
@media only screen and (min-width: 600px) {
	#app {
		width: 50vw;
		margin: 0 auto;
	}
}
</style>
