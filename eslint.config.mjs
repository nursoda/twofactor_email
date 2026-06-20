import { recommendedVue2 } from '@nextcloud/eslint-config'

export default [
	...recommendedVue2,
	{
		// L10n is an intentional single-word translation helper component
		files: ['src/components/L10n.vue'],
		rules: {
			'vue/multi-word-component-names': 'off',
		},
	},
]
