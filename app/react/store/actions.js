module.exports = {
    loadData() {
        return {type: 'LOAD_DATA'};
    },
    feedData(sources, targets) {
        return {type: 'FEED_DATA', sources: sources, targets: targets};
    },
    getSourceContent(id, callback) {
        return {type: 'LOAD_SOURCE_CONTENT', id: id, callback: callback};
    },
    feedSourceContent(id, files) {
        return {type: 'FEED_SOURCE_CONTENT', id: id, files: files};
    },
    getTargetContent(id) {
        return {type: 'LOAD_TARGET_CONTENT', id: id};
    }
};