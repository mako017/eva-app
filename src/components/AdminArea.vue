<template>
	<div class="root">
		<h1>Admin Area</h1>
		<div class="nav">
			<span :class="{ active: navigation === 1 }" @click="navigation = 1">Course Administration</span>
			<span :class="{ active: navigation === 2 }" @click="navigation = 2">Data Export</span>
		</div>
		<hr />
		<CourseAdmin v-if="navigation === 1" />
		<DataExport v-else-if="navigation === 2" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseAdmin from "@/components/AdminArea/CourseAdmin.vue";
import DataExport from "@/components/AdminArea/DataExport.vue";

@Component({
	components: {
		DataExport,
		CourseAdmin,
	},
})
export default class AdminArea extends Vue {
	private navigation = 1;
}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
	.nav {
		width: 100%;
		display: grid;
		grid-template-columns: 1fr 1fr;
		span {
			cursor: pointer;
			&.active {
				color: rgb(0, 138, 7);
				font-weight: bold;
			}
			&:hover {
				font-weight: bold;
			}
		}
	}
}
</style>
