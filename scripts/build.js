'use strict';

// Do this as the first thing so that any code reading it knows the right env.
process.env.BABEL_ENV = 'production';
process.env.NODE_ENV = 'production';

// Makes the script crash on unhandled rejections instead of silently
// ignoring them. In the future, promise rejections that are not handled will
// terminate the Node.js process with a non-zero exit code.
process.on('unhandledRejection', (err) => {
  throw err;
});

// Ensure environment variables are read.
require('../config/env');

const fs = require('fs-extra');
const webpack = require('webpack');
const configFactory = require('../config/webpack.config');
const paths = require('../config/paths');

// Generate configuration
const config = configFactory('production');

// Remove all content but keep the directory so that
// if you're in it, you don't end up in Trash
fs.emptyDirSync(paths.appBuild);
// Start the webpack build
webpack(config, (err, stats) => {
  if (err) {
    console.error(err.stack || err);

    if (err.details) {
      console.error(err.details);
    }

    return;
  }

  if (stats.hasErrors()) {
    console.error(stats.toString({
      all: false,
      colors: true,
      errors: true,
    }));
    console.log();
    return;
  }

  if (stats.hasWarnings()) {
    console.warn(stats.toString({
      all: false,
      colors: true,
      errors: true,
    }));
  }

  console.log('\x1b[32m%s\x1b[0m', 'Build succeeded. \n');
});
