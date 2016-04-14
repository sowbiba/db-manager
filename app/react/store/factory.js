var Redux = require('redux');

module.exports = function () {
    return Redux.applyMiddleware(
        require('./middlewares/api')
    )
    (Redux.createStore)
    (Redux.combineReducers({
        workspace: require('./reducers/workspace')
    }));
};


/**
 * var Redux = require('redux');

 module.exports = function () {
    return Redux.applyMiddleware(
        require('./middlewares/api'),
        require('./middlewares/data')
    )
    (Redux.createStore)
    (Redux.combineReducers({
        workspace: require('./reducers/workspace'),
        modals: require('./reducers/modals'),
        status: require('./reducers/status')
    }));
};
 **/