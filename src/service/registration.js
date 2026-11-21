import Axios from '@nextcloud/axios'
import { generateUrl } from 'nextcloud-server/dist/router.js'

/**
 * Starts the verification.
 *
 * @return {Promise<{state: number, emailAddress: string}>}
 */
export function startVerification() {
	const url = generateUrl('/apps/twofactor_email/settings/enable')

	return Axios.post(url).then((resp) => resp.data)
}

/**
 * Compares the entered code with the generated/saved one.
 *
 * @param {string} code the user entered
 * @return {Promise<Array>} an empty array
 */
export function tryVerification(code) {
	const url = generateUrl('/apps/twofactor_email/settings/validate')

	return Axios.post(url, {
		verificationCode: code,
	}).then((resp) => resp.data)
}

/**
 * Disables the Two-Factor method for this user.
 *
 * @return {Promise<{state: number, emailAddress: string}>}
 */
export function disable() {
	const url = generateUrl('/apps/twofactor_email/settings/disable')

	return Axios.delete(url).then((resp) => resp.data)
}
