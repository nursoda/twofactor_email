<template>
	<span>{{ translated }}</span>
</template>

<script>
export default {
	props: {
		text: {
			type: String,
			required: true,
		},
		options: {
			type: Object,
			default() {
				return {}
			},
		},
	},
	computed: {
		translated() {
			return t('twofactor_email', this.text, this.options || {})
		},
	},
}
</script>
