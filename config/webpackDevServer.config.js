'use strict';

const protocol = process.env.HTTPS === 'true' ? 'https' : 'http';
const host = process.env.HOST || '0.0.0.0';

const webpackDevServerConfig = {
  clientLogLevel: 'error',
  compress: true,
  host,
  hot: true,
  https: protocol === 'https',
  open: true,
  overlay: false,
  quiet: true,
  writeToDisk: true,
  before(app, server){
    // This lets us fetch source contents from webpack for the error overlay
    // app.use(evalSourceMapMiddleware(server));
    // This lets us open files from the runtime error overlay.
    // app.use(errorOverlayMiddleware());
  },
}

export default webpackDevServerConfig;
