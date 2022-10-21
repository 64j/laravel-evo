const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  outputDir: '../../../manager/static',
  publicPath: process.env.NODE_ENV === 'production' ? './static/' : '/',
  assetsDir: process.env.NODE_ENV === 'production' ? '../' : 'static',
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
    if (config.plugins.has('extract-css')) {
      const extractCSSPlugin = config.plugin('extract-css')
      extractCSSPlugin && extractCSSPlugin.tap(() => [
          {
            filename: 'app.css',
            chunkFilename: '[id].[chunkhash].css'
          }
        ]
      )
    }
    // config.plugins.delete('html')
    // config.plugins.delete('preload')
    // config.plugins.delete('prefetch')
  }
})
