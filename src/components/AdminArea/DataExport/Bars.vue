<template>
	<div class="root">
		<canvas id="chart" />
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import Chart from "chart.js";

@Component
export default class Bars extends Vue {
	@Prop({ default: [] }) readonly labels!: Array<string>;
	@Prop({ default: [] }) readonly colors!: Array<string>;
	@Prop({ default: [] }) readonly data!: Array<number>;
	readonly options: object = {
		responsive: true,
		maintainAspectRatio: true,
		scales: {
			yAxes: [
				{
					ticks: {
						beginAtZero: true,
					},
				},
			],
		},
	};

	mounted() {
		this.createChart({
			datasets: [
				{
					data: this.data,
					backgroundColor: this.colors,
				},
			],
			labels: this.labels,
		});
	}

	createChart(chartData: object) {
		const canvas = document.getElementById("chart") as HTMLCanvasElement;
		const options = {
			type: "bar",
			data: chartData,
			options: this.options,
		};
		new Chart(canvas, options);
	}
}
</script>

<style lang="scss" scoped></style>
