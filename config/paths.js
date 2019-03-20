'use strict';

import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';

const appDirectory = fs.realpathSync(process.cwd());
const resolveApp = relativePath => path.resolve(appDirectory, relativePath);
const paths = {
  appPackageJson: resolveApp('package.json'),
  source: path.resolve(__dirname, '../src'),
  build: path.resolve(__dirname, '../dist'),
  envfile: path.resolve(__dirname, '.env'),
}

dotenv.config({
  path: paths.envfile,
});

export default paths;
