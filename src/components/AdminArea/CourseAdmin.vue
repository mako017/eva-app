<template>
	<div>
		<CourseTable v-for="(course, id) in courses" :key="id" :course="course" :changes="changes" />
		<div class="newCourse">
			<label for="">LSF: <input type="text" v-model="newCourse.lsf"/></label>
			<label for="">Titel: <input type="text" v-model="newCourse.titel"/></label>
			<i class="material-icons" @click="addCourse">
				add_circle_outline
			</i>
		</div>
		<div class="controlPanel">
			<button @click="_saveCourses">Save Courses</button>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import CourseTable from "@/components/AdminArea/CourseAdmin/CourseTable.vue";
import { changes, user, courseContainer } from "@/components/models.ts";
import { saveCourses, getAllCourses, highestID } from "@/assets/ts/courses.ts";

@Component({
	components: { CourseTable },
})
export default class CourseAdmin extends Vue {
	@Prop()
	private user!: user;
	private newCourse = {
		lsf: "",
		titel: "",
	};
	courses: Array<courseContainer> = [];
	changes: changes = {
		changeID: 0,
		create: [],
		update: [],
		remove: [],
	};
	addCourse() {
		this.courses.push({
			lsf: +this.newCourse.lsf,
			titel: this.newCourse.titel,
			singleCourses: [],
		});
	}
	resetChanges() {
		this.changes = {
			changeID: 0,
			create: [],
			update: [],
			remove: [],
		};
	}
	_saveCourses() {
		if (this.changes.create.length > 0) saveCourses(this.changes.create, "create", this.user.token);
		if (this.changes.remove.length > 0) saveCourses(this.changes.remove, "remove", this.user.token);
		if (this.changes.update.length > 0) saveCourses(this.changes.update, "update", this.user.token);
		this.resetChanges();
	}
	async mounted() {
		await getAllCourses(this.user.token).then(response => (this.courses = response));
		this.changes.changeID = highestID(this.courses);
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
