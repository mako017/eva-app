<template>
	<div class="root">
		<table>
			<thead class="title">
				<th>{{ course.lsf }}</th>
				<th>{{ course.titel }}</th>
				<th>Datum</th>
				<th>Raum</th>
				<th>Von</th>
				<th>Bis</th>
				<th>Sitzung</th>
				<th>Dozent</th>
				<th>
					<i v-if="expanded" @click="expand" class="material-icons">
						expand_more
					</i>
					<i v-else @click="expand" class="material-icons">
						expand_less
					</i>
				</th>
			</thead>
			<tbody :class="{ hidden: !expanded }">
				<tr v-for="(session, id) in course.singleCourses" :key="id">
					<td>{{ course.lsf }}</td>
					<td>{{ course.titel }}</td>
					<td><input type="date" v-model="session.datum" /></td>
					<td><input type="text" maxlength="8" v-model="session.raum" /></td>
					<td><input type="time" v-model="session.von" /></td>
					<td><input type="time" v-model="session.bis" /></td>
					<td><input type="text" v-model="session.sitzung" /></td>
					<td><input type="text" v-model="session.dozent" /></td>
					<td>
						<i class="material-icons" @click="removeSession(id)">
							remove_circle_outline
						</i>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<i class="material-icons" @click="addSession">
							add_circle_outline
						</i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import { courseContainer } from "@/components/models.ts";

@Component
export default class CourseTable extends Vue {
	@Prop() course!: courseContainer;
	private expanded = true;
	removeSession(pos: number) {
		this.course.singleCourses.splice(pos, 1);
	}
	get today() {
		let now = new Date();
		const offset = now.getTimezoneOffset();
		now = new Date(now.getTime() - offset * 60 * 1000);
		return now.toISOString().split("T")[0];
	}
	addSession() {
		this.course.singleCourses.push({
			datum: this.today,
			raum: "",
			von: "00:00",
			bis: "00:00",
			sitzung: "",
			dozent: "",
		});
	}
	expand() {
		this.expanded = !this.expanded;
	}
}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
	margin: 0 0 1rem 0;
}
table {
	width: 100%;
	text-align: left;
	tr:nth-child(even) {
		background-color: rgb(220, 220, 220);
	}
	td,
	th {
		padding: 0 5px;
	}
	input[type="text"] {
		width: 70%;
	}
}
i {
	cursor: pointer;
}
.hidden {
	display: none;
}
.title {
	// widows: 100%;
	// display: flex;
	// flex-direction: row;
	background-color: rgb(190, 190, 190);
	:nth-child(1) {
		margin: 0 10px;
	}
	:last-child {
		margin-left: auto;
	}
}
</style>
