<template>
	<div class="root">
		<h2>Login</h2>
		<form class="login-form">
			<label>User</label>
			<input type="text" v-model="credentials.user" />
			<label>Password</label>
			<input type="password" v-model="credentials.password" />
			<button type="button" @click.prevent.once="signIn">Sign In</button>
		</form>
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
				this.credentials = {
					user: "",
					password: "",
				};
			})
			.catch(error => {
				console.log(error);
			});
	}
}
</script>

<style scoped lang="scss">
.root {
	display: flex;
	flex-direction: column;
	align-items: center;

	* {
		margin: 0.5rem 0;
	}
}
.login-form {
	display: grid;
	grid-template-columns: 1fr 3fr;
	gap: 0.5rem;
	text-align: start;
	border: 1px solid black;
	padding: 0.4rem;
	* {
		margin: 0.2rem 0;
	}
	button {
		justify-self: center;
		grid-column-start: 1;
		grid-column-end: 3;
	}
}
</style>
