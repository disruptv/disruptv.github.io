'use strict';

const querystring = require('querystring');

const overlayStyles = {
  'background': 'rgba(0, 0, 0, 0.9)',
  'boxSizing': 'border-box',
  'fontFamily': 'Menlo, Consolas, monospace',
  'fontSize': 'large',
  'height': '100vh',
  'lineHeight': '1.2',
  'padding': '2rem',
  'whiteSpace': 'pre-wrap',
  'width': '100vw',
};

module.exports = {
  getClient() {
    const host = 'webpack-hot-middleware/client?';
    const query = querystring.stringify({
      path: '/__webpack_hmr',
      timeout: 20000,
      reload: true,
      overlay: true,
      noInfo: true,
      overlayStyles: JSON.stringify(overlayStyles),
    });

    return `${host}${query}`;
  },
};
