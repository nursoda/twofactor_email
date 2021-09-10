import Axios from '@nextcloud/axios'
import { generateUrl } from 'nextcloud-server/dist/router'

export function startVerification() {
	const url = generateUrl('/apps/twofactor_email/settings/enable')

	return Axios.post(url).then(resp => resp.data)
}

export function tryVerification(code) {
	const url = generateUrl('/apps/twofactor_email/settings/validate')

	return Axios.post(url, {
		verificationCode: code,
	}).then(resp => resp.data)
}

export function disable() {
	const url = generateUrl('/apps/twofactor_email/settings/disable')

	return Axios.delete(url).then(resp => resp.data)
}
