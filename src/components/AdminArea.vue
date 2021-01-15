<template>
	<div class="root">
		<h1>Admin Area</h1>
		<div v-if="user.signedIn">
			<div class="nav">
				<span :class="{ active: navigation === 1 }" @click="navigation = 1">Course Administration</span>
				<span :class="{ active: navigation === 2 }" @click="navigation = 2">Data Export</span>
			</div>
			<span>You are logged in as {{ user.name }} (<i @click="logout" class="logout">log out</i>)</span>
			<hr />
			<CourseAdmin :user="user" v-if="navigation === 1" />
			<DataExport :user="user" v-else-if="navigation === 2" />
		</div>
		<AdminLogin v-else v-on:loggedIn="setUser" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import { user } from "@/components/models.ts";
import CourseAdmin from "@/components/AdminArea/CourseAdmin.vue";
import DataExport from "@/components/AdminArea/DataExport.vue";
import AdminLogin from "@/components/AdminArea/Login.vue";
import axios from "axios";

@Component({
	components: {
		DataExport,
		CourseAdmin,
		AdminLogin,
	},
})
export default class AdminArea extends Vue {
	private navigation = 1;
	private user: user = {
		signedIn: false,
		name: "",
		token: "",
	};
	setUser(user: { name: string; token: string }) {
		Object.assign(this.user, user);
		localStorage.setItem("user", JSON.stringify(this.user));
	}
	logout() {
		this.user = {
			signedIn: false,
			name: "",
			token: "",
		};
		localStorage.removeItem("user");
	}
	mounted() {
		const ls = localStorage.getItem("user");
		if (ls !== null) {
			this.user = JSON.parse(ls);
			axios
				.post(
					"./php/handle.php",
					JSON.stringify({
						call: "testToken",
						token: this.user.token,
					}),
				)
				.then(response => {
					if (response.data !== "valid token") {
						this.logout();
					}
				})
				.catch(error => {
					console.log(error);
				});
		}
	}
}
</script>

<style scoped lang="scss">
.root {
	width: 100%;
	.nav {
		width: 100%;
		display: grid;
		grid-template-columns: 1fr 1fr;
		span {
			cursor: pointer;
			&.active {
				color: rgb(0, 138, 7);
				font-weight: bold;
			}
			&:hover {
				font-weight: bold;
			}
		}
	}
	.logout {
		cursor: pointer;
		&:hover {
			font-weight: bold;
		}
	}
}
</style>
