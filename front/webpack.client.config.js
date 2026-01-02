const { merge } = require('webpack-merge');
const base = require('./webpack.base.config');
const path = require('path');
module.exports = merge(base, {
  entry: './src/entry-client.js',
  target: 'web',
  output: { filename: 'client.bundle.js', path: path.resolve(__dirname, 'dist/client') }
});
