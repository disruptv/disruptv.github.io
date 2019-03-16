import chalk from 'chalk';
import fs from 'fs';
import path from 'path';
import webpack from 'webpack';
import webpackDevServer from 'webpack-dev-server';

import webpackConfig from '../config/webpack.config.babel';
import webpackDevServerConfig from '../config/webpackDevServer.config.js';

const appDirectory = fs.realpathSync(process.cwd());
const resolveApp = relativePath => path.resolve(appDirectory, relativePath);
const paths = {
  appPackageJson: resolveApp('package.json'),
};

const PORT = process.env.PORT || 4000;
const HOST = process.env.HOST || '0.0.0.0';
const appName = require(paths.appPackageJson).name;
const compiler = webpack(webpackConfig);
const server = new webpackDevServer(compiler, {...webpackDevServerConfig,
});

server.listen(PORT, HOST, error => {
  if (error) {
    return console.log(error);
  }
  console.log(chalk.cyan('Starting the development server ...\n'));
});

['SIGINT', 'SIGTERM'].forEach( signal => {
  process.on( signal, () => {
    server.close();
    process.exit();
  });
});
