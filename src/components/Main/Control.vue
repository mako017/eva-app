<template>
	<div class="root">
		<button type="button" class="btn">++</button>
		<button type="button" class="btn">+</button>
		<button type="button" class="btn">o</button>
		<button type="button" class="btn">-</button>
		<button type="button" class="btn">--</button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component
export default class extends Vue {}
</script>

<style scoped lang="scss">
.root {
	display: flex;
	flex-direction: column;
	align-items: center;
}
.btn {
	display: inline-block;
	text-decoration: none;
	color: rgba(54, 54, 54, 0.8); /*IconColor*/
	width: 80px;
	height: 80px;
	line-height: 80px;
	font-size: 40px;
	border-radius: 50%;
	text-align: center;
	vertical-align: middle;
	overflow: hidden;
	font-weight: bold;
	background-image: -webkit-linear-gradient(#e8e8e8 0%, #d6d6d6 100%);
	background-image: linear-gradient(#e8e8e8 0%, #d6d6d6 100%);
	text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.66);
	box-shadow: inset 0 2px 0 rgba(255, 255, 255, 0.5), 0 2px 2px rgba(0, 0, 0, 0.19);
	border-bottom: solid 2px #b5b5b5;

	border: none;
	margin: 0.4rem 0;

	&:hover {
		cursor: pointer;
	}
}
.btn:active {
	/*onClick*/
	background-image: -webkit-linear-gradient(#efefef 0%, #d6d6d6 100%);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5), 0 2px 2px rgba(0, 0, 0, 0.19);
	border-bottom: none;
}
</style>
