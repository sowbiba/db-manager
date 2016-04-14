var _ = require('lodash');
var config = require('./common');

module.exports = _.extend({}, config, {
    devServer: {
        colors: true,
        contentBase: __dirname + '/../public',
        historyApiFallback: true,
        inline: true,
        progress: true
    },
    devtool: 'eval-source-map'
});
