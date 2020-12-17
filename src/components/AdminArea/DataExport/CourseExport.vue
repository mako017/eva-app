<template>
	<div>
		<table>
			<thead class="title">
				<th>{{ course.lsf }}</th>
				<th>{{ course.titel }}</th>
				<th>Datum</th>
				<th>Sitzung</th>
				<th>Dozent</th>
				<th>
					<i class="material-icons">
						insert_chart_outlined
					</i>
				</th>
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
					<td><input readonly type="date" v-model="session.datum" /></td>
					<td>{{ session.sitzung }}</td>
					<td>{{ session.dozent }}</td>
					<td>
						<i class="material-icons" @click="_requestResult(course.lsf, session.id)">
							insert_chart_outlined
						</i>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<div v-if="results.length !== 0">
			<p v-if="showID === -1">No data available</p>
			<ResultSlide v-else :result="evaResult[showID]" />
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import ResultSlide from "@/components/AdminArea/DataExport/ResultSlide.vue";
import { courseContainer, singleVote } from "@/components/models.ts";
import { requestResult } from "@/assets/ts/courses.ts";
import { EvaResult, SingleResult } from "@/assets/ts/results.ts";

@Component({
	components: {
		ResultSlide,
	},
})
export default class CourseExport extends Vue {
	@Prop() course!: courseContainer;
	private evaResult: Array<SingleResult> = [];
	private expanded = true;
	private results: Array<singleVote> = [];
	private showID = -1;
	expand() {
		this.expanded = !this.expanded;
	}
	async _requestResult(lsf: number, session: number) {
		console.log(session);
		await requestResult(lsf).then(response => (this.results = response));
		this.evaResult = new EvaResult(this.results).compute();
		this.showID = this.evaResult.findIndex(result => result.session === session);
	}
}
</script>

<style scoped lang="scss">
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
	input {
		border: none;
		margin: 2px 0;
		background-color: transparent;
	}
}
i {
	cursor: pointer;
}
.hidden {
	display: none;
}
.title {
	background-color: rgb(190, 190, 190);
	:nth-child(1) {
		margin: 0 10px;
	}
	:last-child {
		margin-left: auto;
	}
}
</style>
