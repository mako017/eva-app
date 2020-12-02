<template>
	<div>
		<CourseTable v-for="(course, id) in courses" :key="id" :course="course" />
		<div class="newCourse">
			<label for="">LSF: <input type="text" v-model="newCourse.lsf"/></label>
			<label for="">Titel: <input type="text" v-model="newCourse.titel"/></label>
			<i class="material-icons" @click="addCourse">
				add_circle_outline
			</i>
		</div>
		<div class="controlPanel">
			<button @click="saveCourses(courses)">Save Courses</button>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseTable from "@/components/AdminArea/CourseTable.vue";
import { courseContainer } from "@/components/models.ts";
import { saveCourses, requestCourses } from "@/assets/ts/courses.ts";

@Component({
	components: { CourseTable },
})
export default class CourseAdmin extends Vue {
	private newCourse = {
		lsf: "",
		titel: "",
	};
	courses: Array<courseContainer> = [
		{
			id: 1,
			lsf: 123456,
			titel: "Anatomie",
			singleCourses: [
				{
					datum: "2020-11-30",
					raum: "09 GYN",
					von: "10:15",
					bis: "11:45",
					sitzung: "Herz I",
					dozent: "Prof. Dr. Kardio",
				},
				{
					datum: "2020-12-07",
					raum: "09 GYN",
					von: "10:15",
					bis: "11:45",
					sitzung: "Herz II",
					dozent: "Prof. Dr. Kardio",
				},
			],
		},
	];
	addCourse() {
		this.courses.push({
			id: this.courses.length > 0 ? this.courses[this.courses.length - 1].id + 1 : 1,
			lsf: +this.newCourse.lsf,
			titel: this.newCourse.titel,
			singleCourses: [],
		});
	}
	mounted() {
		requestCourses();
	}
}
</script>

<style scoped lang="scss">
.newCourse {
	background-color: rgb(190, 190, 190);
	width: 98%;
	display: flex;
	flex-direction: row;
	align-items: center;
	padding: 0 1%;
	i {
		margin: 0 1% 0 auto;
		cursor: pointer;
	}
}
.controlPanel {
	margin-top: 1rem;
}
</style>
