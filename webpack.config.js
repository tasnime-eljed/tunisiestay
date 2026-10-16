const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Dossier de sortie des assets compilés
    .setOutputPath('public/build/')
    // Chemin public pour le serveur web
    .setPublicPath('/build')

    // Point d'entrée principal
    .addEntry('app', './assets/app.js')

    // Symfony Stimulus Bridge
    .enableStimulusBridge('./assets/controllers.json')

    // Optimisation : découpe les fichiers en morceaux
    .splitEntryChunks()

    // Script runtime.js séparé
    .enableSingleRuntimeChunk()

    // Nettoie public/build avant chaque compilation
    .cleanupOutputBeforeBuild()

    // Tailwind CSS via PostCSS
    .enablePostCssLoader()

    // Source maps en développement uniquement
    .enableSourceMaps(!Encore.isProduction())

    // Noms de fichiers hashés en production
    .enableVersioning(Encore.isProduction())

    // Babel configuration
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })
;

module.exports = Encore.getWebpackConfig();