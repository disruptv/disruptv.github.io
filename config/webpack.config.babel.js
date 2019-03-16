import path from 'path';
import webpack from 'webpack';

const config = {
  webpack: {},
}

const entry = {
  'react': path.resolve('./src/index.js'),
}

config.webpack = {
  mode: process.env.NODE_ENV || 'development',
  entry: entry,
  devtool: 'inline-source-map',
}

export default config.webpack;
