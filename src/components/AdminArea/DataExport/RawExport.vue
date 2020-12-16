<template>
	<div>
		<button @click="requestCSV" type="button">Export all results</button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component
export default class RawExport extends Vue {
	requestCSV() {
		window.open("./php/export/rawData.php", "_blank");
	}
}
</script>

<style scoped></style>
