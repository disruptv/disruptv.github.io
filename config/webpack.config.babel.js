'use strict';

import BrowserSyncPlugin from 'browser-sync-webpack-plugin';
import CleanWebpackPlugin from 'clean-webpack-plugin';
import CopyWebpackPlugin from 'copy-webpack-plugin';
import Dotenv from 'dotenv-webpack';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import OptimizeCSSAssetsPlugin from 'optimize-css-assets-webpack-plugin';
import path from 'path';
import safePostCssParser from 'postcss-safe-parser';
import TerserPlugin from 'terser-webpack-plugin';

import paths from './paths';

const entry = {
  'react': './src/index.jsx',
  'vendors': './src/assets/js/vendors.js',
  'style': './src/assets/scss/style.scss',
}
const output = {
  path: paths.build,
  filename: 'assets/js/[name].js',
}
const rules = [
  //js, jsx, ts, tsx
  {
    test: /\.(j|t)s(x)?$/,
    exclude: /node_modules/,
    use: [
      {
        loader: 'babel-loader',
      },
    ],
  },
  //images
  {
    test: /\.(png|svg|jpg|gif)$/,
    use: [
      {
        'loader': 'file-loader',
        'options': {
          useRelativePath: true,
          name: '[name].[ext]',
          context: paths.source,
          publicPath: paths.build + '/assets/img/',
        },
      },
    ],
  },
  // fonts
  {
    test: /\.(ttf|eot|woff|woff2)$/,
    use: {
      loader: 'file-loader',
      options: {
        name: 'fonts/[name].[ext]',
      },
    },
  },
  // scss
  {
    test: /\.(s)?css$/,
    use: [
      MiniCssExtractPlugin.loader,
      {
        loader: 'css-loader',
        options: {
          // modules: true,
          camelCase: true,
          // getLocalIdent: (context, localIdentName, localName) => {
          //   return generateScopedName(localName, context.resourcePath);
          // },
          // localIdentName: '[name]_[local]_[hash:base64:5]',
          sourceMap: process.env.NODE_ENV !== 'production' ? true : false,
          importLoaders: 2,
        },
      },
      {
        loader: 'postcss-loader',
        options: {
          plugins: [require('autoprefixer')({
            browsers: [
              'last 2 versions',
              'ie >= 9',
              'android >= 4.4',
              'ios >= 7',
            ],
          })],
          sourceMap: process.env.NODE_ENV !== 'production' ? true : false,
        },
      },
      {
        loader: 'sass-loader',
        options: {
          includePaths: [
            path.resolve(__dirname, '../node_modules'),
            path.resolve(__dirname, '../node_modules/foundation-sites/scss'),
          ],
          sourceMap: process.env.NODE_ENV !== 'production' ? true : false,
        },
      },
    ],
  },
]
const modules = {
  rules
}
const resolve = {
  modules:['node_modules'],
  extensions:[
    '.js',
    '.jsx',
    '.scss'
  ],
}
const performance = {}
const externals = {
  jquery: 'jQuery',
  // react: 'React',
  // reactDOM: 'ReactDOM',
}
const optimization = {
  minimize: process.env.NODE_ENV === 'production' ? true : false,
  minimizer: [
    new TerserPlugin({
      terserOptions: {
        parse: {
          ecma: 8,
        },
        compress: {
          ecma: 5,
          warnings: false,
          comparisons: false,
          inline: 2,
        },
        mangle: {
          safari10: true,
        },
        output: {
          ecma: 5,
          comments: false,
          ascii_only: true,
        },
      },
      parallel: true,
      cache: true,
      sourceMap: process.env.NODE_ENV !== 'production' ? true : false,
    }),
    // This is only used in production mode
    new OptimizeCSSAssetsPlugin({
      cssProcessorOptions: {
        parser: safePostCssParser,
        map: process.env.NODE_ENV !== 'production' ? true : false
          ? {
              inline: false,
              annotation: true,
            }
          : false,
      },
    }),
  ],
  // splitChunks: {
  //   chunks: 'all',
  //   name: false,
  // },
}
const plugins = [
  new BrowserSyncPlugin({
    host: process.env.HOST || '0.0.0.0',
    port: process.env.PORT || 4000,
    proxy: 'http://localhost:9000',
  }),
  // new CleanWebpackPlugin(),
  new CopyWebpackPlugin([
    paths.source + '/**/*.php',
    paths.source + '/screenshot.*',
    paths.source + '/assets/fonts/**/*',
  ], {
    context: 'src/',
  }
  ),
  new Dotenv({
    path: paths.envfile,
  }),
  new MiniCssExtractPlugin({
    filename: 'style.css',
    chunkFilename: process.env.NODE_ENV !== 'production' ?
      'assets/css/[id].css' : 'assets/css/[id].[hash].css',
  }),
]

const webpackConfig = {
  mode: process.env.NODE_ENV || 'development',
  context: path.resolve(__dirname, '../'),
  entry: entry,
  output: output,
  optimization: optimization,
  module: modules,
  resolve: resolve,
  performance: performance,
  devtool: process.env.NODE_ENV === 'production' ? false : 'inline-source-map',
  target: 'web',
  externals: externals,
  stats: 'errors-only',
  plugins: plugins,
  watch: process.env.NODE_ENV !== 'production' ? true : false,
  cache: true,
}

export default webpackConfig;
