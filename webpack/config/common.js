var root = __dirname + '/../..';

module.exports = {
    entry: {
        javascript: root + '/webpack/initialize.js',
        html: root + '/webpack/public/index.html'
    },
    output: {
        filename: 'revisions.js',
        path: root + '/webpack/compiled'
    },
    module: {
        loaders: [
            { test: /\.js$/, loaders: [ 'react-hot', 'jsx' ], exclude: /node_modules/ },
            { test: /\.css$/, loaders: [ 'style', 'css?sourceMap' ], includePaths: [ root + '/stylesheets' ] },
            { test: /\.html$/, loader: 'file' }
        ]
    }
};
