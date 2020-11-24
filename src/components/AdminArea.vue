<template>
	<div class="root">
		<h1>Admin Area</h1>
		<div class="nav">
			<span>Course Administration</span>
			<span>Data Export</span>
		</div>
		<hr />
		<DataExport />
		<CourseAdmin />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseAdmin from "@/components/AdminArea/CourseAdmin.vue";
import DataExport from "@/components/AdminArea/CourseAdmin.vue";

@Component({
	components: {
		DataExport,
		CourseAdmin,
	},
})
export default class AdminArea extends Vue {}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
}
</style>
