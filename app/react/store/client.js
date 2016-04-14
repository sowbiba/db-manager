var router = require('./client/router');
var requests = require('./client/requests')(router);

module.exports = function () {
    return {
        getData: function (callback) {
            requests.loadData(function (error, data) {
                if (error) callback(error);
                callback(null, { sources: data.sources, targets: data.targets });
            });
        }
    };
};
