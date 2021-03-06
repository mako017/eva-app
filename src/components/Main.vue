<template>
	<div class="main">
		<Evaluation :infos="infos" v-on:sendData="sendData" v-if="!finished" />
		<Finish :lsf="infos.lsf" :optLink="infos.optLink" :liveFB="infos.liveFB" :session="{ lsf: infos.lsf, id: infos.Counter, dozent: infos.doz, sitzung: infos.sitzung }" class="finish" v-else />
		<DataPrivacy v-if="showNotice" v-on:closeNotice="showNotice = false" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Evaluation from "@/components/Main/Evaluation.vue";
import Finish from "@/components/Main/Finish.vue";
import DataPrivacy from "@/components/Main/DataPrivacy.vue";
import FingerprintJS from "@fingerprintjs/fingerprintjs";
import axios from "axios";

@Component({
	components: {
		Evaluation,
		Finish,
		DataPrivacy,
	},
})
export default class Main extends Vue {
	private infos = {
		doz: "Prof. Dr. Sarah Dozent",
		titel: "Anatomie",
		sitzung: "Herz",
		lsf: 123456,
		Counter: 0,
		fp: "",
		optLink: "",
		liveFB: false,
	};
	private finished = false;
	private showNotice = true;
	private noCourse = true;
	sendData(val: number) {
		this.finished = true;
		this.showNotice = false;
		axios.post(
			"./php/handle.php",
			JSON.stringify({
				call: "transferData",
				payload: {
					session: this.infos.Counter,
					lsf: this.infos.lsf,
					wertung: val,
					fp: this.infos.fp,
				},
			}),
		);
	}
	async getFingerprint() {
		const fp = await FingerprintJS.load();
		const result = await fp.get();
		const visitorId = result.visitorId;
		return visitorId;
	}
	getCourseinfo() {
		let newInfos = {
			exists: false,
			doz: "",
			titel: "",
			sitzung: "",
			lsf: "",
		};
		const URLParams = this.handleURL();
		if (URLParams.lsf === "NaN" && URLParams.loc === "NaN") {
			return;
		}
		axios
			.post(
				"./php/handle.php",
				JSON.stringify({
					call: "requestCourse",
					payload: {
						lsf: URLParams.lsf,
						location: URLParams.loc,
					},
				}),
			)
			.then(response => {
				newInfos = response.data;
				this.infos = Object.assign(this.infos, newInfos);
				console.log(this.infos);
			})
			.catch(error => {
				console.log(error);
			});
	}
	handleURL(): { lsf: string | null; loc: string | null } {
		const paramString = window.location.search;
		const parameters = new URLSearchParams(paramString);
		const URLParams = {
			lsf: parameters.get("l") ? parameters.get("l")! : "NaN",
			loc: parameters.get("r") ? parameters.get("r")! : "NaN",
		};
		this.infos.lsf = +URLParams.lsf;
		return URLParams;
	}
	mounted() {
		console.log("Hello World");
		this.getFingerprint().then(res => {
			this.infos.fp = res;
		});
		this.getCourseinfo();
	}
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.main {
	display: flex;
	justify-content: center;
}
.head {
	text-align: left;
	padding: 0 0.5rem;
	h1 {
		text-align: center;
		font-size: 1.6rem;
		margin-bottom: 0.6rem;
	}
	span {
		font-weight: bold;
	}
	p {
		text-align: justify;
		margin: 0.5rem 0;
	}
}
.finish {
	margin-top: 30%;
}
</style>
