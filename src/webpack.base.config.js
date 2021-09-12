const path = require('path')
const { VueLoaderPlugin } = require('vue-loader')

module.exports = {
	entry: './src/init.js',
	output: {
		filename: '2fa-email.js',
		path: path.resolve(__dirname, '../js'),
	},
	resolve: {
		modules: [path.resolve(__dirname), 'node_modules'],
		fallback: {
			fs: false,
		},
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: {},
				},
			},
			{
				test: /\.css$/,
				use: [
					{
						loader: 'vue-style-loader',
					},
					{
						loader: 'css-loader',
						options: {
							modules: true,
						},
					},
				],
			},
		],
	},
	plugins: [
		new VueLoaderPlugin(),
	],
}
