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
		<div class="results" v-if="liveFB">
			<p>Der Dozent / Die Dozentin hat zugestimmt, dass Ihnen die Ergebnisse der Befragung live präsentiert werden. Das unten stehende Diagramm wird alle 10 Sekunden aktualisiert.</p>
			<ResultSlide :result="evaResult[showID]" :head="showInfo" />
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import { singleVote, singleCourse } from "@/components/models.ts";
import { requestResult } from "@/assets/ts/courses.ts";
import { EvaResult, SingleResult } from "@/assets/ts/results.ts";
import ResultSlide from "@/components/AdminArea/DataExport/ResultSlide.vue";

@Component({
	components: {
		ResultSlide,
	},
})
export default class Finish extends Vue {
	@Prop({ default: "" }) optLink!: string;
	@Prop({ default: "" }) lsf!: number;
	@Prop({ default: false }) liveFB!: boolean;
	@Prop({ default: false }) session!: singleCourse;
	private results: Array<singleVote> = [];
	private evaResult: Array<SingleResult> = [];
	private showID = -1;
	private showInfo = {
		titel: this.session.sitzung,
		doz: this.session.dozent,
	};
	async _requestResult(lsf: number, session: singleCourse) {
		await requestResult(lsf, session.id, "none").then(response => (this.results = response));
		this.evaResult = new EvaResult(this.results).compute();
		this.showID = this.evaResult.findIndex(result => result.session === session.id);
		this.showInfo.titel = session.sitzung;
		this.showInfo.doz = session.dozent;
	}
	timerHandle() {
		this._requestResult(this.lsf, this.session);
	}
	created() {
		this._requestResult(this.lsf, this.session);
		setInterval(this.timerHandle, 10000);
	}
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
	margin: 1rem auto;
}
</style>
