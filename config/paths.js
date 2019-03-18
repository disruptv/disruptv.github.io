'use strict';

import fs from 'fs';
import path from 'path';

const appDirectory = fs.realpathSync(process.cwd());
const resolveApp = relativePath => path.resolve(appDirectory, relativePath);
const paths = {
  appPackageJson: resolveApp('package.json'),
  source: path.resolve(__dirname, '../src'),
  build: path.resolve(__dirname, '../dist'),
  envfile: path.resolve(__dirname, '../dist'),
}

export default paths;
