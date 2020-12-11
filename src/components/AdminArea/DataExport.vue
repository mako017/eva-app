<template>
	<div class="root">
		<CourseExport v-for="(course, id) in courses" :key="id" :course="course" />
		<hr />
		<RawExport />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseExport from "@/components/AdminArea/CourseExport.vue";
import RawExport from "@/components/AdminArea/RawExport.vue";
import { getAllCourses } from "@/assets/ts/courses.ts";
import { courseContainer } from "@/components/models.ts";

@Component({
	components: {
		RawExport,
		CourseExport,
	},
})
export default class DataExport extends Vue {
	courses: Array<courseContainer> = [];
	async mounted() {
		await getAllCourses().then(response => (this.courses = response));
	}
}
</script>

<style scoped lang="scss"></style>
