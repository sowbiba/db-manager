var send = function (URL, options, success) {
    if (_.isFunction (options)) {
        success = options;
        options = undefined;
    }

    $.ajax(_.extend({
        url: URL,
        crossDomain: true,
        dataType: 'json',
        cache: false,
        success: success,
        error: function (xhr, status, err) {
            console.error(URL, status, err.toString(), options);
        }
    }, options));
};

var respond = function (callback) {
    return function (data) {
        var errors = null;

        if (! data.success) {
            errors = data.response;
            if (data.technical_message)
                console.error(data.technical_message);
        }

        callback(errors, data.response);
    }
};

module.exports = function (router) {
    return {
        loadData: function (callback) {
            send(
                router.loadData(),
                respond(callback)
            );
        }
    }
};
