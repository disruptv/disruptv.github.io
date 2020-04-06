'use strict';

const fs = require('fs');
const path = require('path');
const webpack = require('webpack');
const PnpWebpackPlugin = require('pnp-webpack-plugin');
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const safePostCssParser = require('postcss-safe-parser');
const paths = require('./paths');
const postcssNormalize = require('postcss-normalize');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const appPackageJson = require(paths.appPackageJson);

const shouldUseSourceMap = process.env.MTF_GENERATE_SOURCEMAP !== 'false';

const imageInlineSizeLimit = parseInt(
    process.env.MTF_IMAGE_INLINE_SIZE_LIMIT || '10000',
);

// Check if TypeScript is setup
const useTypeScript = fs.existsSync(paths.appTsConfig);

// style files regexes
const cssRegex = /\.css$/;
const cssModuleRegex = /\.module\.css$/;
const sassRegex = /\.(scss|sass|pcss)$/;
const sassModuleRegex = /\.module\.(scss|sass|pcss)$/;

// This is the production and development configuration.
// It is focused on developer experience, fast rebuilds, and a minimal bundle.
module.exports = function(webpackEnv = 'development') {
  const isEnvDevelopment = webpackEnv === 'development';
  const isEnvProduction = webpackEnv === 'production';

  // Variable used for enabling profiling in Production
  // passed into alias object. Uses a flag if passed into the build command
  const isEnvProductionProfile =
    isEnvProduction && process.argv.includes('--profile');

  const getCSSModuleLocalIdent = (context, localIdentName, localName) => {
    return generateScopedName(localName, context.resourcePath);
  };

  // common function to get style loaders
  const getStyleLoaders = (cssOptions, preProcessor) => {
    const loaders = [
      isEnvDevelopment && require.resolve('style-loader'),
      {
        loader: MiniCssExtractPlugin.loader,
      },
      {
        loader: require.resolve('css-loader'),
        options: cssOptions,
      },
      {
        loader: require.resolve('postcss-loader'),
        options: {
          ident: 'postcss',
          plugins: () => [
            require('postcss-flexbugs-fixes'),
            require('postcss-preset-env')({
              autoprefixer: {
                flexbox: 'no-2009',
              },
              stage: 3,
            }),
            postcssNormalize(),
          ],
          sourceMap: isEnvProduction && shouldUseSourceMap,
        },
      },
    ].filter(Boolean);
    if (preProcessor) {
      loaders.push(
          {
            loader: require.resolve('resolve-url-loader'),
            options: {
              sourceMap: isEnvProduction && shouldUseSourceMap,
            },
          },
          {
            loader: require.resolve(preProcessor),
            options: {
              sourceMap: true,
            },
          },
      );
    }
    return loaders;
  };

  return {
    mode: isEnvProduction ? 'production' : isEnvDevelopment && 'development',
    bail: isEnvProduction,
    devtool: isEnvProduction ?
      shouldUseSourceMap ?
        'source-map' :
        false :
      isEnvDevelopment && 'cheap-module-source-map',
    entry: paths.appIndex,
    output: {
      path: isEnvProduction ? paths.appBuild : paths.appTemp,
      pathinfo: isEnvDevelopment,
      filename: 'static/js/[name].js',
      // TODO: remove this when upgrading to webpack 5
      futureEmitAssets: true,
      // chunkFilename: isEnvProduction ?
      //   'static/js/[name].[contenthash:8].chunk.js' :
      //   isEnvDevelopment && 'static/js/[name].chunk.js',
      devtoolModuleFilenameTemplate: isEnvProduction ?
        (info) =>
          path
              .relative(paths.appSrc, info.absoluteResourcePath)
              .replace(/\\/g, '/') :
        isEnvDevelopment &&
        ((info) => path.resolve(info.absoluteResourcePath).replace(/\\/g, '/')),
      jsonpFunction: `webpackJsonp${appPackageJson.name}`,
      globalObject: 'this',
    },
    optimization: {
      minimize: isEnvProduction,
      minimizer: [
        // This is only used in production mode
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
            keep_classnames: isEnvProductionProfile,
            keep_fnames: isEnvProductionProfile,
            output: {
              ecma: 5,
              comments: false,
              ascii_only: true,
            },
          },
          sourceMap: shouldUseSourceMap,
        }),
        // This is only used in production mode
        new OptimizeCSSAssetsPlugin({
          cssProcessorOptions: {
            parser: safePostCssParser,
            map: shouldUseSourceMap ?
              {
                inline: false,
                annotation: true,
              } :
              false,
          },
          cssProcessorPluginOptions: {
            preset: ['default', {minifyFontValues: {removeQuotes: false}}],
          },
        }),
      ],
      splitChunks: {
        chunks: 'all',
        name: false,
      },
      // runtimeChunk: {
      //   name: (entrypoint) => `runtime-${entrypoint.name}`,
      // },
    },
    resolve: {
      modules: ['node_modules', paths.appNodeModules],
      extensions: paths.moduleFileExtensions
          .map((ext) => `.${ext}`)
          .filter((ext) => useTypeScript || !ext.includes('ts')),
      plugins: [
        PnpWebpackPlugin,
      ],
    },
    resolveLoader: {
      plugins: [
        PnpWebpackPlugin.moduleLoader(module),
      ],
    },
    externals: {
      jquery: 'jQuery',
    },
    module: {
      strictExportPresence: true,
      rules: [
        {parser: {requireEnsure: false}},
        {
          test: /\.(js|mjs|jsx|ts|tsx)$/,
          enforce: 'pre',
          use: [
            {
              options: {
                cache: true,
                eslintPath: require.resolve('eslint'),
                resolvePluginsRelativeTo: __dirname,
              },
              loader: require.resolve('eslint-loader'),
            },
          ],
          include: paths.appSrc,
        },
        {
          oneOf: [
            {
              test: [/\.bmp$/, /\.gif$/, /\.jpe?g$/, /\.png$/],
              loader: require.resolve('url-loader'),
              options: {
                limit: imageInlineSizeLimit,
                name: 'static/media/[name].[hash:8].[ext]',
              },
            },
            {
              test: /\.(js|mjs|jsx|ts|tsx)$/,
              include: paths.appSrc,
              loader: require.resolve('babel-loader'),
              options: {
                cacheDirectory: true,
                cacheCompression: false,
                compact: isEnvProduction,
                babelrc: false,
                configFile: false,
              },
            },
            {
              test: /\.(js|mjs)$/,
              exclude: [
                /@babel(?:\/|\\{1,2})runtime/,
              ],
              loader: require.resolve('babel-loader'),
              options: {
                babelrc: false,
                configFile: false,
                compact: false,
                cacheDirectory: true,
                cacheCompression: false,
                sourceMaps: shouldUseSourceMap,
                inputSourceMap: shouldUseSourceMap,
              },
            },
            {
              test: cssRegex,
              exclude: cssModuleRegex,
              use: getStyleLoaders({
                importLoaders: 1,
                sourceMap: isEnvProduction && shouldUseSourceMap,
              }),
              sideEffects: true,
            },
            {
              test: cssModuleRegex,
              use: getStyleLoaders({
                importLoaders: 1,
                sourceMap: isEnvProduction && shouldUseSourceMap,
                modules: {
                  // getLocalIdent: getCSSModuleLocalIdent,
                },
              }),
            },
            {
              test: sassRegex,
              exclude: sassModuleRegex,
              use: getStyleLoaders(
                  {
                    importLoaders: 3,
                    sourceMap: isEnvProduction && shouldUseSourceMap,
                  },
                  'sass-loader',
              ),
              sideEffects: true,
            },
            {
              test: sassModuleRegex,
              use: getStyleLoaders(
                  {
                    importLoaders: 3,
                    sourceMap: isEnvProduction && shouldUseSourceMap,
                    modules: {
                    // getLocalIdent: getCSSModuleLocalIdent,
                    },
                  },
                  'sass-loader',
              ),
            },
            {
              loader: require.resolve('file-loader'),
              exclude: [/\.(js|mjs|jsx|ts|tsx)$/, /\.html$/, /\.json$/],
              options: {
                name: 'static/media/[name].[hash:8].[ext]',
              },
            },
            // ** STOP ** Are you adding a new loader?
            // Make sure to add the new loader(s) before the "file" loader.
          ],
        },
      ],
    },
    plugins: [
      isEnvDevelopment && new webpack.HotModuleReplacementPlugin(),
      isEnvDevelopment && new CaseSensitivePathsPlugin(),
      isEnvDevelopment &&
      new BrowserSyncPlugin({
        host: process.env.HOST || '0.0.0.0',
        port: process.env.WEB_PORT || 4000,
        proxy: process.env.PROXY ? process.env.PROXY : null,
        open: false,
      }),
      new MiniCssExtractPlugin({
        filename: 'static/css/[name].css',
        // chunkFilename: 'static/css/[name].chunk.css',
      }),
      new CopyWebpackPlugin([
        'style.css',
        'screenshot.*',
        '*.php',
        '*.json',
        'assets/fonts/**',
        'assets/img/**',
        'classes/**',
        'inc/**',
      ], {
        context: 'src',
      }),
      new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
    ].filter(Boolean),
    node: {
      module: 'empty',
      dgram: 'empty',
      dns: 'mock',
      fs: 'empty',
      http2: 'empty',
      net: 'empty',
      tls: 'empty',
      child_process: 'empty',
    },
    performance: false,
  };
};
