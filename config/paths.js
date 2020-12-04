'use strict';

const fs = require('fs');
const path = require('path');

const appDirectory = fs.realpathSync(process.cwd());
const HMR = require('./hmr.js');
const hmr = HMR.getClient();

const moduleFileExtensions = [
  'web.mjs',
  'mjs',
  'web.js',
  'js',
  'web.ts',
  'ts',
  'web.tsx',
  'tsx',
  'json',
  'web.jsx',
  'jsx',
];

const appCopyFiles = [
  'style.css',
  'screenshot.*',
  '*.php',
  '*.json',
  'admin/**',
  'assets/fonts/**',
  'assets/img/**',
  'classes/**',
  'inc/**',
  'template-parts/**',
];

const resolveApp = (relativePath) => path.resolve(appDirectory, relativePath);

module.exports = {
  dotenv: resolveApp('.env'),
  appPath: resolveApp('.'),
  appBuild: resolveApp('disruptv'),
  appTemp: resolveApp('disruptv'),
  appFiles: {
    'screen': process.env.NODE_ENV === 'development' ?
      [hmr, resolveApp('src/assets/scss/screen.scss')] :
      resolveApp('src/assets/scss/screen.scss'),
    'print': process.env.NODE_ENV === 'development' ?
      [hmr, resolveApp('src/assets/scss/print.scss')] :
      resolveApp('src/assets/scss/print.scss'),
    'vendors': process.env.NODE_ENV === 'development' ?
      [hmr, resolveApp('src/assets/js/vendors.js')] :
      resolveApp('src/assets/js/vendors.js'),
  },
  appPackageJson: resolveApp('package.json'),
  appSrc: resolveApp('src'),
  appTsConfig: resolveApp('tsconfig.json'),
  appJsConfig: resolveApp('jsconfig.json'),
  appNodeModules: resolveApp('node_modules'),
};

module.exports.moduleFileExtensions = moduleFileExtensions;
module.exports.appCopyFiles = appCopyFiles;
