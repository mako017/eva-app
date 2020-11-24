<template>
	<div class="root">
		<h1>Eva App</h1>
		<span>Dozent:</span><br />
		<span>Titel: </span>
		<p>Bitte nutzen Sie die Knöpfe unten um anzugeben, wie zufrieden Sie mit dieser Sitzung waren.</p>
		<Control v-on:sendData="sendData" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Control from "@/components/Main/Control.vue";

@Component({
	components: {
		Control,
	},
})
export default class Evaluation extends Vue {}
</script>

<style scoped lang="scss">
.root {
	text-align: left;
	padding: 0 0.5rem;
	h1 {
		text-align: center;
		font-size: 1.6rem;
		margin-bottom: 0.6rem;
	}
	span {
		font-weight: bold;
	}
	p {
		text-align: justify;
		margin: 0.5rem 0;
	}
}
</style>
