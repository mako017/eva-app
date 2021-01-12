<template>
	<div class="root">
		<div class="big-frame">
			<span>Vielen Dank für Ihre Teilnahme</span>
		</div>
		<div class="small-frame">
			<span>Ihre Daten wurden erfolgreich gespeichert. Sie können das Fenster nun schließen.</span>
		</div>
		<div class="optLink" v-if="optLink.trim() !== ''">
			<p>Der Dozent / Die Dozentin möchte Sie außerdem darauf hinweisen, dass Sie unter folgendem Link weitere Informationen zu der heutigen Sitzung finden können.</p>
			<a v-bind:href="optLink">{{ optLink }}</a>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";

@Component
export default class Finish extends Vue {
	@Prop({ default: "" })
	optLink!: string;
}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
}

.big-frame {
	background-color: rgb(140, 188, 107);
	color: white;
	font-size: 2rem;
	width: 100%;
	text-align: center;
	padding: 0.5rem 0;
}

.small-frame {
	width: 100%;
	background-color: rgb(217, 217, 217);
	text-align: center;
	color: black;
	padding: 0.5rem 0;
}

.optLink {
	margin-top: 1rem;
}
</style>
