<template>
	<div class="root">
		<div class="card">
			<span class="close">×</span>
			<qrcode-vue :value="url" :size="size" level="H"></qrcode-vue>
			<label>URL<br /><input readonly v-bind="url"/></label>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import QrcodeVue from "qrcode.vue";

@Component({
	components: { QrcodeVue },
})
export default class QRmodal extends Vue {
	@Prop()
	url!: string;
	private value = "asd";
	private size = 300;
}
</script>

<style scoped lang="scss">
.root {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	padding: 1rem 0;
	background-color: rgba(255, 255, 255, 0.4);
	display: flex;
	justify-content: center;
	.card {
		background-color: white;
		width: 40%;
		height: 70%;
		border: 1px solid black;
		display: flex;
		flex-direction: column;
		* {
			margin: 1rem 0;
		}
		.close {
			text-align: end;
			font-size: 2rem;
		}
	}
}
</style>
