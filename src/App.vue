<template>
	<div id="app">
		<Main />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Main from "./components/Main.vue";

@Component({
	components: {
		Main,
	},
})
export default class App extends Vue {}
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
