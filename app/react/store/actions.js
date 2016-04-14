module.exports = {
    loadData() {
        return {type: 'LOAD_DATA'};
    },
    feedData(sources, targets) {
        return {type: 'FEED_DATA', sources: sources, targets: targets};
    }
};