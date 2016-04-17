module.exports = {
    loadData: function () {
        return Routing.generate('operations_data');
    },
    loadSourceContent: function (id) {
        return Routing.generate('source_data', {id: id});
    }
};