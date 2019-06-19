import {nc_fetch_json} from 'nextcloud_fetch';

export function getVerificationState () {
	let url = OC.generateUrl('/apps/twofactor_email/settings/state')

	return nc_fetch_json(url).then(function (resp) {
		if (resp.ok) {
			return resp.json().then(json => {
				json.isAvailable = true
				return json
			})
		}
		if (resp.status === 503) {
			return {
				isAvailable: false
			}
		}
		throw resp
	})
}

export function startVerification () {
	let url = OC.generateUrl('/apps/twofactor_email/settings/enable')

	return nc_fetch_json(url, {
		method: 'POST',
	}).then(function (resp) {
		if (resp.ok) {
			return resp.json();
		}
		throw resp;
	})
}


export function tryVerification (code) {
	let url = OC.generateUrl('/apps/twofactor_email/settings/validate')

	return nc_fetch_json(url, {
		method: 'POST',
		body: JSON.stringify({
			verificationCode: code
		})
	}).then(function (resp) {
		if (resp.ok) {
			return resp.json();
		}
		throw resp;
	})
}

export function disable () {
	let url = OC.generateUrl('/apps/twofactor_email/settings/disable')

	return nc_fetch_json(url, {
		method: 'DELETE'
	}).then(function (resp) {
		if (resp.ok) {
			return resp.json();
		}
		throw resp;
	})
}
