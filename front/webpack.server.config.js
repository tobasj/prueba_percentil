const { merge } = require('webpack-merge');
const base = require('./webpack.base.config');
const path = require('path');
const webpack = require('webpack');
module.exports = merge(base, {
  entry: './src/entry-server.js',
  target: 'node',
  output: { filename: 'server.bundle.js', libraryTarget: 'commonjs2', path: path.resolve(__dirname, 'dist/server') },
  externalsPresets: { node: true },
  plugins: [ new webpack.DefinePlugin({ 'process.env.VUE_ENV': '"server"' }) ]
});
