<template>
	<div>
		<div v-if="!isAvailable">
			<L10n text="To be able to activate Two-Factor Email you need to set an email address in your user account first." />
		</div>
		<div v-else-if="loading">
			<span class="icon-loading-small" />
		</div>
		<div v-else>
			<p v-if="state === states.DISABLED">
				<L10n text="Two-Factor Email is not activated. It may send codes to the email address set in your user account." />
				<br />
				<button @click="enable">
					<L10n text="Enable email verification" />
				</button>
			</p>
			<p v-if="state === states.CREATED">
				<strong v-if="verificationError === true">
					<L10n text="The code entered did not match. A new code was sent. Please retry." />
				</strong>
				<L10n text="A code has been sent to {emailAddress}. Please insert it here:"
					:options="{emailAddress: emailAddress}" />
				<input v-model="confirmationCode">
				<button @click="confirm">
					<L10n text="Verify code" />
				</button>
				<button @click="disable">
					<L10n text="Cancel activation" />
				</button>
			</p>
			<p v-if="state === states.ENABLED">
				<L10n text="Two-Factor Email is active. Codes are sent to {emailAddress}."
					:options="{emailAddress: emailAddress}" />
				<button @click="disable">
					<L10n text="Disable email verification" />
				</button>
			</p>
		</div>
	</div>
</template>

<script>
import L10n from './L10n.vue'
import {
	startVerification,
	tryVerification,
	disable,
} from '../service/registration'
import { loadState } from '@nextcloud/initial-state'

export default {
	name: 'GatewaySettings',
	components: {
		L10n,
	},
	data() {
		const STATE = {
			DISABLED: 0,
			CREATED: 1,
			ENABLED: 2,
		}

		return {
			loading: false,
			states: STATE,
			state: STATE.DISABLED,
			emailAddress: '',
			isAvailable: true,
			confirmationCode: '',
			verificationError: false,
		}
	},
	mounted() {
		this.isAvailable = loadState('twofactor_email', 'available')
		const state = loadState('twofactor_email', 'state')
		this.state = state.state
		this.emailAddress = state.emailAddress
	},
	methods: {
		enable() {
			this.loading = true
			this.verificationError = false
			startVerification()
				.then(res => {
					this.state = this.states.CREATED
					this.emailAddress = res.emailAddress
					this.loading = false
				})
				.catch(e => {
					console.error(e)
					this.state = this.states.DISABLED
					this.verificationError = true
					this.loading = false
				})
		},
		confirm() {
			this.loading = true

			tryVerification(this.confirmationCode)
				.then(res => {
					this.state = this.states.ENABLED
					this.loading = false
				})
				.catch(res => {
					this.state = this.states.CREATED
					this.verificationError = true
					this.loading = false
				})
		},

		disable() {
			this.loading = true

			disable()
				.then(res => {
					this.state = res.state
					this.emailAddress = res.emailAddress
					this.loading = false
				})
				.catch(console.error.bind(this))
		},
	},
}
</script>

<style>
	.icon-loading-small {
		padding-left: 15px;
	}
</style>
