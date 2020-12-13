<template>
	<div class="root" @click.self="closeModal">
		<div class="card">
			<i class="material-icons close" @click.self="closeModal">close</i>
			<qrcode-vue :value="url" :size="size" level="Q"></qrcode-vue>
			<label for="url">URL</label>
			<div class="copyURL">
				<input type="text" name="url" readonly v-model="url" />
				<button @click.prevent="copyURL" type="button" class="material-icons">link</button>
			</div>
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
	@Prop() url!: string;
	@Prop() showModal!: boolean;
	private value = "asd";
	private size = 300;
	closeModal() {
		this.$emit("closeModal");
	}
	copyURL() {
		this.closeModal();
		this.$emit("copyURL");
	}
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
}
.card {
	z-index: 1000;
	background-color: white;
	width: 30%;
	height: fit-content;
	border: 1px solid black;
	display: flex;
	flex-direction: column;
	* {
		margin: 1rem 0;
	}
}
.close {
	cursor: pointer;
	align-self: flex-end;
	margin: 0.5rem 0.5rem 0 0;
}
.copyURL {
	display: flex;
	justify-content: center;
	input {
		width: 70%;
	}
}
</style>
