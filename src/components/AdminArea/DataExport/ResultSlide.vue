<template>
	<div class="root">
		<div class="data">
			<span>Titel: </span>
			<span>Doz: </span>
			<span>N = {{ result.N }}</span>
			<span>M = {{ result.mean }}</span>
			<span>SD = {{ result.sd }}</span>
		</div>
		<Bars :data="[result.A, result.B, result.C, result.D, result.E]" :labels="['++', '+', 'o', '-', '--']" :colors="['black', 'black', 'black', 'black', 'black']" />
	</div>
</template>

<script lang="ts">
import Bars from "@/components/AdminArea/DataExport/Bars.vue";
import { Component, Prop, Vue } from "vue-property-decorator";
import { RawResults } from "@/assets/ts/results.ts";

@Component({
	components: {
		Bars,
	},
})
export default class ResultSlide extends Vue {
	@Prop() result!: RawResults;
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
