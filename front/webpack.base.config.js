const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  mode: 'development',
  output: { path: path.resolve(__dirname, 'dist') },
  resolve: { extensions: ['.js', '.vue'], alias: { '@': path.resolve(__dirname, 'src') } },
  module: {
    rules: [
      { test: /\.vue$/, loader: 'vue-loader' },
      { 
        test: /\.js$/, 
        loader: 'babel-loader', 
        exclude: /node_modules/,
        options: { 
          presets: [['@babel/preset-env', { targets: { node: '10' }, modules: 'commonjs' }]],
          sourceType: 'unambiguous'
        }
      },
      { test: /\.s?css$/, use: ['vue-style-loader', 'css-loader', 'sass-loader'] },
      { test: /\.(png|jpg|gif|svg)$/, loader: 'file-loader' }
    ]
  },
  plugins: [new VueLoaderPlugin()]
};
