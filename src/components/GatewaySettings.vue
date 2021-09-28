<template>
	<div>
		<div v-if="!isAvailable">
			<L10n text="You need to set an email address in 'Personal info' first." />
		</div>
		<div v-else-if="loading">
			<span class="icon-loading-small" />
		</div>
		<div v-else>
			<p v-if="state === states.DISABLED">
				<button @click="enable">
					<L10n text="Enable email verification" />
				</button>
			</p>
			<p v-if="state === states.CREATED">
				<span v-if="verificationError === true">
					<L10n text="The entered code did not match. A new " />
				</span>
				<span v-if="verificationError === false">
					<L10n text="A " />
				</span>
				<L10n text="code has been sent to {emailAddress}."
					:options="{emailAddress: emailAddress}" />
				<br />
				<L10n text="Please insert it here:" />
				<input v-model="confirmationCode">
				<button @click="confirm">
					<L10n text="Verify code" />
				</button>
				<button @click="disable">
					<L10n text="Cancel activation" />
				</button>
			</p>
			<p v-if="state === states.ENABLED">
				<L10n text="Codes are sent to {emailAddress}."
					:options="{emailAddress: emailAddress}" />
				<br />
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
