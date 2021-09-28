<template>
	<div>
		<p>
			<L10n text="The server can send access codes to your email address." />
		</p>
	</div>
</template>

<script>
import L10n from './L10n.vue'
export default {
	name: 'EmailInstructions',
	components: {
		L10n,
	},
}
</script>
