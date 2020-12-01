<template>
	<div>
		<CourseTable v-for="(course, id) in mockCourses" :key="id" :course="course" />
		<div class="newCourse">
			<label for="">LSF: <input type="text" v-model="newCourse.lsf"/></label>
			<label for="">Titel: <input type="text" v-model="newCourse.titel"/></label>
			<i class="material-icons" @click="addCourse">
				add_circle_outline
			</i>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseTable from "@/components/AdminArea/CourseTable.vue";
import { courseContainer } from "@/components/models.ts";

@Component({
	components: { CourseTable },
})
export default class CourseAdmin extends Vue {
	private newCourse = {
		lsf: "",
		titel: "",
	};
	mockCourses: Array<courseContainer> = [
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
		{
			id: 2,
			lsf: 987654,
			titel: "Pharmazie",
			singleCourses: [
				{
					datum: "2020-11-30",
					raum: "45 BIO",
					von: "10:15",
					bis: "11:45",
					sitzung: "Antibiotika I",
					dozent: "Prof. Dr. Paracelsus",
				},
				{
					datum: "2020-12-07",
					raum: "45 BIO",
					von: "10:15",
					bis: "11:45",
					sitzung: "Antibiotika II",
					dozent: "Prof. Dr. Paracelsus",
				},
			],
		},
	];
	addCourse() {
		this.mockCourses.push({
			id: this.mockCourses.length > 0 ? this.mockCourses[this.mockCourses.length - 1].id + 1 : 1,
			lsf: +this.newCourse.lsf,
			titel: this.newCourse.titel,
			singleCourses: [],
		});
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
</style>
