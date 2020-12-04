module.exports = {
	publicPath: process.env.NODE_ENV === "production" ? "./" : "/",
	devServer: {
		proxy: {
			"^/php": {
				target: "http://localhost/evabox",
				changeOrigin: true,
			},
		},
	},
};
