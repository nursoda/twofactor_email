<template>
	<span>{{ translated }}</span>
</template>

<script>
export default {
	props: ['text', 'options'],
	computed: {
		translated: function() {
			return t('twofactor_email', this.text, this.options || {})
		},
	},
}
</script>
