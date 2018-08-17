<!--
  - @copyright Copyright (c) 2018 Roeland Jago Douma <roeland@famdouma.nl>
  -
  - @author Roeland Jago Douma <roeland@famdouma.nl>
  -
  - @license GNU AGPL version 3 or any later version
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
  -
  -->
<template>
	<div class="section" id="email-second-factor-auth">
		<h2>{{ t('twofactor_email', 'E-mail second-factor auth') }}</h2>
		<template v-if="state === states.DISABLED">
			<button v-on:click="enable">Enable</button>
		</template>
		<template v-else-if="state === states.CREATED">
			{{ t('twofactor_email', 'We send a validation code to your configured e-mail address.')}}
			<input v-model="challenge" type="tel" minlength="6" maxlength="6" name="challenge" required="required" autocomplete="off" autocapitalize="off" />
			<button v-on:click="validate">Validate</button>
		</template>
		<template v-else-if="state === states.ENABLED">
			<button v-on:click="disable">Disable</button>
		</template>
	</div>
</template>

<script>
import axios from 'axios';

export default {
	name: 'App',
	data: function() {
		var STATE = {
			DISABLED: 0,
			CREATED: 1,
			ENABLED: 2
		};

		return {
			states: STATE,
			state: STATE.DISABLED,
			challenge: ''
		};
	},
	beforeMount: function() {
		let requestToken = OC.requestToken;
		let tokenHeaders = { headers: { requesttoken: requestToken } };

		axios.get(OC.generateUrl('apps/twofactor_email/settings/state'), tokenHeaders)
			.then((response) => {
			this.state = response.data.state ? this.states.ENABLED : this.states.DISABLED;
		});
	},
	methods: {
		enable() {
			let requestToken = OC.requestToken;
			let tokenHeaders = { headers: { requesttoken: requestToken } };

			axios.post(
				OC.generateUrl('apps/twofactor_email/settings/enable'),
				{} ,
				tokenHeaders)
				.then((response) => {
					this.state = this.states.CREATED;
				});
		},
		validate() {
			let requestToken = OC.requestToken;
			let tokenHeaders = { headers: { requesttoken: requestToken } };

			axios.post(
				OC.generateUrl('apps/twofactor_email/settings/validate'),
				{
					token: this.challenge
				},
				tokenHeaders)
				.then((response) => {
					this.state = response.data.state;
				}
			);
		},
		disable() {
			let requestToken = OC.requestToken;
			let tokenHeaders = { headers: { requesttoken: requestToken } };

			axios.post(
				OC.generateUrl('apps/twofactor_email/settings/disable'),
				{} ,
				tokenHeaders)
				.then((response) => {
					this.state = this.states.DISABLED;
				});
		},
	},
}
</script>
