<template>
	<div>
		{{ evaResult }}
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import { EvaResult, RawResults, SingleResult } from "@/assets/ts/results.ts";

@Component
export default class ResultSlide extends Vue {
	@Prop() results!: Array<RawResults>;
	private evaResult: Array<SingleResult> = [];
	mounted() {
		this.evaResult = new EvaResult(this.results).compute();
	}
}
</script>

<style scoped></style>
