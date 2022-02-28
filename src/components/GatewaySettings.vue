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
				<span v-if="ErrorDetected === true">
					<L10n text="Could not send a verification code via email. An Admin must set this up first." />
				</span>
				<span v-else>
					<button @click="enable">
						<L10n text="Enable Two-Factor Email" />
					</button>
				</span>
			</p>
			<p v-if="state === states.CREATED">
				<span v-if="ErrorDetected === true">
					<L10n text="The entered code does not match that sent to {emailAddress}."
						:options="{emailAddress: emailAddress}" />
				</span>
				<span v-else>
					<L10n text="A code has been sent to {emailAddress}."
						:options="{emailAddress: emailAddress}" />
				</span>
				<br>
				<input v-model="confirmationCode">
				<button @click="confirm">
					<L10n text="Verify code" />
				</button>
				<button @click="disable">
					<L10n text="Cancel activation" />
				</button>
			</p>
			<p v-if="state === states.ENABLED">
				<L10n text="Two-Factor Email is enabled. Codes are sent to {emailAddress}."
					:options="{emailAddress: emailAddress}" />
				<br>
				<button @click="disable">
					<L10n text="Disable Two-Factor Email" />
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
			ErrorDetected: false,
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
			this.ErrorDetected = false
			startVerification()
				.then(res => {
					this.state = this.states.CREATED
					this.emailAddress = res.emailAddress
					this.loading = false
				})
				.catch(reason => {
					this.state = this.states.DISABLED
					this.ErrorDetected = true
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
				.catch(reason => {
					this.state = this.states.CREATED
					this.ErrorDetected = true
					this.loading = false
				})
		},

		disable() {
			this.loading = true

			disable()
				.then(res => {
					this.state = this.states.DISABLED
					this.emailAddress = res.emailAddress
					this.loading = false
				})
				.catch(reason => {
					this.ErrorDetected = true
					console.error(reason)
				})
		},
	},
}
</script>

<style>
	.icon-loading-small {
		padding-left: 15px;
	}
</style>
