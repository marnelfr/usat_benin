var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    //.enableVersioning()
    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('admin', './assets/js/admin.js')
    .addEntry('home', './assets/js/guest/home.js')
    .addEntry('menu', './assets/js/menu/menu.js')
    .addEntry('user', './assets/js/user/user.js')
    .addEntry('statistic', './assets/js/statistic/statistic.js')
    .addEntry('register', './assets/js/guest/register.js')
    .addEntry('importer', './assets/js/importer/importer.js')
    .addEntry('remover', './assets/js/remover/remover.js')
    .addEntry('vehicle', './assets/js/vehicle/vehicle.js')
    .addEntry('transfer', './assets/js/transfer/transfer.js')
    .addEntry('transfer_treatment', './assets/js/transfer/transfer_treatment.js')
    .addEntry('removal', './assets/js/removal/removal.js')
    .addEntry('removal_treatment', './assets/js/removal/removal_treatment.js')
  //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')


    .copyFiles({
      from: './assets/images',
      // optional target path, relative to the output dir
      to: 'images/[path][name].[ext]',

      // if versioning is enabled, add the file hash too
      //to: 'images/[path][name].[hash:8].[ext]',
    })

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .configureBabel(function (babelConfig) {
    babelConfig.plugins.push("@babel/plugin-proposal-class-properties")
  })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
    .copyFiles([
      {from: './node_modules/ckeditor/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
      {from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
      {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
      {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
      {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
;

// module.exports = Encore.getWebpackConfig();

var config = Encore.getWebpackConfig();

//disable amd loader
config.module.rules.unshift({
  parser: {
    amd: false,
  }
});

module.exports = config;