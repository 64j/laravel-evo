const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  publicPath: './',
  outputDir: '../dist',
  assetsDir: 'static',
  transpileDependencies: true,
  productionSourceMap: false,
  filenameHashing: true,

  configureWebpack: {
    optimization: {
      splitChunks: false
    },
    output: {
      filename: 'app.js',
      chunkFilename: '[id].[chunkhash].js'
    }
  },

  chainWebpack: config => {
    if(config.plugins.has('extract-css')) {
      const extractCSSPlugin = config.plugin('extract-css')
      extractCSSPlugin && extractCSSPlugin.tap(() => [{
        filename: 'app.css',
        chunkFilename: '[id].[chunkhash].css'
      }])
    }
  },
})
