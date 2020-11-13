<template>
	<div class="main">
		<div class="head" v-if="!finished">
			<h1>Eva App</h1>
			<span>Dozent: {{ infos.doz }}</span
			><br />
			<span>Titel: {{ infos.titel }}</span>
			<p>Bitte nutzen Sie die Knöpfe unten um anzugeben, wie zufrieden Sie mit dieser Sitzung waren.</p>
			<Control v-on:sendData="sendData" />
		</div>
		<Finish class="finish" v-else />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Control from "@/components/Main/Control.vue";
import Finish from "@/components/Main/Finish.vue";

@Component({
	components: {
		Control,
		Finish,
	},
})
export default class HelloWorld extends Vue {
	private infos = {
		doz: "Prof. Dr. Sarah Dozent",
		titel: "Anatomie",
	};
	private finished = false;
	sendData() {
		this.finished = true;
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
