<template>
	<div class="root">
		<label>User<input type="text" v-model="credentials.user"/></label>
		<label>Password<input type="password" v-model="credentials.password"/></label>
		<button type="button" @click.prevent.once="signIn">Sign In</button>
	</div>
</template>

<script lang="ts">
import axios from "axios";
import { Component, Vue } from "vue-property-decorator";

@Component
export default class AdminLogin extends Vue {
	private credentials = {
		user: "",
		password: "",
	};
	signIn() {
		axios
			.post(
				"./php/handle.php",
				JSON.stringify({
					call: "login",
					payload: this.credentials,
				}),
			)
			.then(response => {
				this.$emit("loggedIn", {
					name: this.credentials.user,
					token: response.data,
					signedIn: true,
				});
			})
			.catch(error => {
				console.log(error);
			});
	}
}
</script>

<style scoped></style>
