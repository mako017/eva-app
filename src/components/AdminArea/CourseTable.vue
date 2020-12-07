<template>
	<div class="root">
		<table>
			<thead class="title">
				<th>
					<div>
						<span>{{ course.lsf }}</span>
						<div>
							<i class="material-icons" @click="toggleModal">
								qr_code_2
							</i>
							<i class="material-icons" @click="linkToClipboard">
								link
							</i>
						</div>
					</div>
				</th>
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
					<td><input @change="updateSession(id)" type="date" v-model="session.datum" /></td>
					<td><input @change="updateSession(id)" type="text" maxlength="8" v-model="session.raum" /></td>
					<td><input @change="updateSession(id)" type="time" v-model="session.von" /></td>
					<td><input @change="updateSession(id)" type="time" v-model="session.bis" /></td>
					<td><input @change="updateSession(id)" type="text" v-model="session.sitzung" /></td>
					<td><input @change="updateSession(id)" type="text" v-model="session.dozent" /></td>
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
		<QRModal v-if="showModal" v-on:closeModal="toggleModal" v-on:copyURL="linkToClipboard" :url="url" />
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import { changes, courseContainer } from "@/components/models.ts";
import { initdbCourse, handleChange } from "@/assets/ts/courses.ts";
import QRModal from "@/components/AdminArea/QRModal.vue";

@Component({
	components: { QRModal },
})
export default class CourseTable extends Vue {
	@Prop() course!: courseContainer;
	@Prop() changes!: changes;
	private expanded = true;
	private showModal = false;
	removeSession(pos: number) {
		handleChange(this.changes, initdbCourse(this.course, this.course.singleCourses[pos]), "remove");
		this.course.singleCourses.splice(pos, 1);
	}
	get today() {
		let now = new Date();
		const offset = now.getTimezoneOffset();
		now = new Date(now.getTime() - offset * 60 * 1000);
		return now.toISOString().split("T")[0];
	}
	get url() {
		return "https://qualis.uni-saarland.de/evabox/?l=" + this.course.lsf;
	}
	addSession() {
		this.changes.changeID += 1;
		const newSession = {
			id: this.changes.changeID,
			datum: this.today,
			raum: "",
			von: "00:00",
			bis: "00:00",
			sitzung: "",
			dozent: "",
		};
		this.course.singleCourses.push(newSession);
		handleChange(this.changes, initdbCourse(this.course, newSession), "create");
	}
	linkToClipboard() {
		const el = document.createElement("textarea");
		el.value = this.url;
		el.setAttribute("readonly", "");
		el.style.position = "absolute";
		el.style.left = "-9999px";
		document.body.appendChild(el);
		el.select();
		el.setSelectionRange(0, 99999);
		document.execCommand("copy");
		document.body.removeChild(el);
	}
	updateSession(id: number) {
		handleChange(this.changes, initdbCourse(this.course, this.course.singleCourses[id]), "update");
	}
	expand() {
		this.expanded = !this.expanded;
	}
	toggleModal() {
		this.showModal = !this.showModal;
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
