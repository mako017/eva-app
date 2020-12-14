<template>
	<div>
		{{ evaResult }}
		<canvas id="bars"></canvas>
	</div>
</template>

<script lang="ts">
import Chart from "chart.js";
import { Component, Prop, Vue } from "vue-property-decorator";
import { EvaResult, RawResults, SingleResult } from "@/assets/ts/results.ts";

@Component
export default class ResultSlide extends Vue {
	@Prop() results!: Array<RawResults>;
	private evaResult: Array<SingleResult> = [];

	private labels = ["++", "+", "o", "-", "--"];
	@Prop({ default: [] }) readonly colors!: Array<string>;
	@Prop({ default: [] }) readonly data!: Array<number>;
	@Prop({
		default: () => {
			return Chart.defaults.doughnut;
		},
	})
	readonly options: object | undefined;

	mounted() {
		this.evaResult = new EvaResult(this.results).compute();
		this.createChart({
			datasets: [
				{
					data: this.data,
				},
			],
			labels: this.labels,
		});
	}
	createChart(chartData: object) {
		const canvas = document.getElementById("doughnut") as HTMLCanvasElement;
		const options = {
			type: "doughnut",
			data: chartData,
			options: this.options,
		};
		new Chart(canvas, options);
	}
}
</script>

<style scoped></style>
