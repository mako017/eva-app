<template>
	<div class="root">
		<CourseExport v-for="(course, id) in courses" :key="id" :course="course" :userToken="user.token" />
		<hr />
		<RawExport />
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import CourseExport from "@/components/AdminArea/DataExport/CourseExport.vue";
import RawExport from "@/components/AdminArea/DataExport/RawExport.vue";
import { getAllCourses } from "@/assets/ts/courses.ts";
import { courseContainer, user } from "@/components/models.ts";

@Component({
	components: {
		RawExport,
		CourseExport,
	},
})
export default class DataExport extends Vue {
	@Prop()
	private user!: user;
	courses: Array<courseContainer> = [];
	async mounted() {
		await getAllCourses(this.user.token).then(response => (this.courses = response));
	}
}
</script>

<style scoped lang="scss"></style>
