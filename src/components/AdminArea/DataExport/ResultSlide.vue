<template>
	<div class="root">
		<div class="data">
			<span>Titel: </span>
			<span>Doz: </span>
			<span>N = {{ evaResult[1].N }}</span>
			<span>M = {{ evaResult[1].mean }}</span>
			<span>SD = {{ evaResult[1].sd }}</span>
		</div>
		<Bars :data="[evaResult[1].A, evaResult[1].B, evaResult[1].C, evaResult[1].D, evaResult[1].E]" :labels="['++', '+', 'o', '-', '--']" :colors="['black', 'black', 'black', 'black', 'black']" />
	</div>
</template>

<script lang="ts">
import Bars from "@/components/AdminArea/DataExport/Bars.vue";
import { Component, Prop, Vue } from "vue-property-decorator";
import { EvaResult, RawResults, SingleResult } from "@/assets/ts/results.ts";

@Component({
	components: {
		Bars,
	},
})
export default class ResultSlide extends Vue {
	@Prop() results!: Array<RawResults>;
	private evaResult: Array<SingleResult> = [];
	mounted() {
		this.evaResult = new EvaResult(this.results).compute();
	}
}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
	display: grid;
	grid-template-columns: 2fr 3fr;
	* {
		width: 100%;
	}
}
.data {
	margin: 1rem 0.5rem;
	display: flex;
	flex-direction: column;
	text-align: start;
	line-height: 1.2rem;
}
</style>
