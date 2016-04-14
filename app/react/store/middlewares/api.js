var _ = require('lodash');
var actions = require('../actions');
var Client = require('../client');

module.exports = function (store) {
    var client = null;

    return function (next) {
        return function (action) {
            console.log(action);
            switch (action.type) {

                case 'LOAD_DATA':

                    client = Client();

                    client.getData(function (error, data) {
                        store.dispatch(actions.feedData(data.sources, data.targets));
                        if (action.callback) action.callback(data);
                    });

                    break;
            }

            next(action);
        };
    };
};