<template>
	<div>
		<div v-if="!isAvailable">
			<L10n text="The Email two-factor authentication method is not available. Do you have an email address set?"/>
		</div>
		<div v-else-if="loading">
			<span class="icon-loading-small"></span>
		</div>
		<div v-else>
			<p v-if="state === states.DISABLED">
				<slot name="instructions"/>
				<L10n text="You are not using Email as a two-factor authentication method at the moment."/>
				<button @click="enable">
					<L10n text="Enable"/>
				</button>
			</p>
			<p v-if="state === states.CREATED">
				<strong v-if="verificationError === true">
					<L10n text="Could not verify your code. Please try again."></L10n>
				</strong>
				<L10n text="A confirmation code has been sent to {emailAddress}. Please insert the code here:"
				      :options="{emailAddress: emailAddress}" />
				<input v-model="confirmationCode">
				<button @click="confirm">
					<L10n text="Verify"/>
				</button>
				<button @click="disable">
					<L10n text="Cancel"/>
				</button>
			</p>
			<p v-if="state === states.ENABLED">
				<L10n text="Your account was successfully configured to receive authentication codes via Email to {emailAddress}."
				      :options="{emailAddress: emailAddress}" />
				<button @click="disable">
					<L10n text="Disable"/>
				</button>
			</p>
		</div>
	</div>
</template>

<script>
	import L10n from "components/L10n.vue";
	import {
		getVerificationState,
		startVerification,
		tryVerification,
		disable
	} from "service/registration";

	export default {
		name: "GatewaySettings",
		data () {
			var STATE = {
				DISABLED: 0,
				CREATED: 1,
				ENABLED: 2
			};

			return {
				loading: true,
				states: STATE,
				state: STATE.DISABLED,
				emailAddress: '',
				isAvailable: true,
				confirmationCode: '',
				verificationError: false
			};
		},
		mounted: function () {
			getVerificationState()
				.then(res => {
					console.debug('loaded state for email', res);
					this.isAvailable = res.isAvailable;
					this.state = res.state;
					this.emailAddress = res.emailAddress;
				})
				.catch(console.error.bind(this))
				.then(() => this.loading = false);
		},
		methods: {
			enable: function () {
				this.loading = true;
				this.verificationError = false;
				startVerification()
					.then(res => {
						this.state = this.states.CREATED;
						this.emailAddress = res.emailAddress;
						this.loading = false;
					})
					.catch(e => {
						console.error(e);
						this.state = this.states.DISABLED;
						this.verificationError = true;
						this.loading = false;
					});
			},
			confirm: function () {
				this.loading = true;

				tryVerification(this.confirmationCode)
					.then(res => {
						this.state = this.states.ENABLED;
						this.loading = false;
					})
					.catch(res => {
						this.state = this.states.CREATED;
						this.verificationError = true;
						this.loading = false;
					});
			},

			disable: function () {
				this.loading = true;

				disable()
					.then(res => {
						this.state = res.state;
						this.emailAddress = res.emailAddress;
						this.loading = false;
					})
					.catch(console.error.bind(this));
			}
		},
		components: {
			L10n
		}
	}
</script>

<style>
	.icon-loading-small {
		padding-left: 15px;
	}
</style>
