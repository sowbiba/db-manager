var root = __dirname + '/../..';
var projectRoot = __dirname + '/../../../..';

module.exports = {
    entry: {
        javascript: root + '/webpack/initialize.js'
    },
    output: {
        filename: 'operations.js',
        path: projectRoot + '/src/AppBundle/Resources/public/javascripts/'
    },
    module: {
        loaders: [
            { test: /\.js$/, loaders: [ 'react-hot', 'jsx' ], exclude: /node_modules/ },
            { test: /\.css$/, loaders: [ 'style', 'css?sourceMap' ], includePaths: [ root + '/stylesheets' ] },
            { test: /\.html$/, loader: 'file' }
        ]
    }
};
