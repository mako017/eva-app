<template>
	<div class="root">
		<CourseExport />
		<hr />
		<RawExport />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseExport from "@/components/AdminArea/CourseExport.vue";
import RawExport from "@/components/AdminArea/RawExport.vue";

@Component({
	components: {
		RawExport,
		CourseExport,
	},
})
export default class DataExport extends Vue {}
</script>

<style scoped lang="scss"></style>
