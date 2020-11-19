<template>
	<div class="root">
		<div class="head">
			<h4 class="title">Datenschutz</h4>
			<span class="close">×</span>
		</div>
		<span class="note">Mit Ihrer Teilnahme an der Evaluation stimmen Sie unseren <a href="">Datenschutzbedingungen</a> zu.</span>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component
export default class DataPrivacy extends Vue {}
</script>

<style scoped lang="scss">
.root {
	position: absolute;
	bottom: 5px;
	width: 98%;
	border: 1px solid gray;
	max-width: 500px;
	background-color: rgb(217, 217, 217);
	display: flex;
	flex-direction: column;
	text-align: left;
	.head {
		display: flex;
		flex-direction: row;
		.close {
			margin: 0.5% 1% 0 auto;
			font-size: 1.5rem;
		}
		.title {
			margin: 1% 0 0 1%;
			font-size: 1.1rem;
		}
	}
	.note {
		margin: 0 0 1% 1%;
	}
}
</style>
