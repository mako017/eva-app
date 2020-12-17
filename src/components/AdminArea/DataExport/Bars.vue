<template>
	<div class="root">
		<canvas id="chart" />
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from "vue-property-decorator";
import Chart from "chart.js";

@Component
export default class Bars extends Vue {
	@Prop({ default: [] }) readonly labels!: Array<string>;
	@Prop({ default: [] }) readonly colors!: Array<string>;
	@Prop({ default: [] }) readonly data!: Array<number>;
	chartObj: Chart | undefined = undefined;
	readonly options: object = {
		responsive: true,
		maintainAspectRatio: true,
		legend: {
			display: false,
		},
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
		this.initChart();
	}

	@Watch("data")
	onPropertyChange() {
		this.chartObj?.destroy();
		this.initChart();
	}

	createChart(chartData: object) {
		const canvas = document.getElementById("chart") as HTMLCanvasElement;
		const options = {
			type: "bar",
			data: chartData,
			options: this.options,
		};
		this.chartObj = new Chart(canvas, options);
	}
	initChart() {
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
}
</script>

<style lang="scss" scoped></style>
