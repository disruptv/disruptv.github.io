'use strict';

process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development';

process.on('unhandledRejection', (err) => {
  throw err;
});

require('../config/env');

const path = require('path');
const fs = require('fs-extra');
const webpack = require('webpack');
const browserSync = require('browser-sync').create();
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');
const configFactory = require('../config/webpack.config');
const paths = require('../config/paths');

const PORT = parseInt(process.env.WEB_PORT, 10) || 3000;
const HOST = process.env.HOST || '0.0.0.0';

const config = configFactory('development');

fs.emptyDirSync(paths.appTemp);

const compiler = webpack(config);
const middleware = [
  webpackDevMiddleware(compiler, {
    publicPath: paths.appTemp,
    writeToDisk: true,
    logLevel: 'error',
    quiet: true,
  }),
  webpackHotMiddleware(compiler, {
    log: false,
    // logLevel: 'none'
  }),
];

browserSync.init({
  host: HOST || '0.0.0.0',
  port: PORT || 4000,
  middleware,
  proxy: {
    target: process.env.PROXY ? process.env.PROXY : null,
    middleware,
  },
  // logLevel: 'silent',
  files: ['../**/*.php'].map((element) => path.resolve(element)),
  snippetOptions: {
    rule: {
      match: /<\/head>/i,
      fn: function (snippet, match) {
        return `<script src="${paths.appTemp}"></script>${snippet}${match}`;
      },
    },
  },
  open: false,
});
