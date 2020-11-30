<template>
	<div>
		<CourseTable v-for="(course, id) in mockCourses" :key="id" :course="course" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import CourseTable from "@/components/AdminArea/CourseTable.vue";

@Component({
	components: { CourseTable },
})
export default class CourseAdmin extends Vue {
	mockCourses = [
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
}
</script>

<style scoped></style>
