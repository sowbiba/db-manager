var _ = require('lodash');

module.exports = function (state, action) {
    state = state || [];

    var index;

    switch (action.type) {

        case 'FEED_DATA':
            console.log(action);

            return {  sources: action.sources, targets: action.targets};

    //    case 'OPEN_CHAPTER':
    //
    //        index = _.findIndex(state, { key: 'C' + action.id });
    //
    //        if (action.table)
    //            return _.union(
    //                state.slice(0, index + 1),
    //                [{ type: 'table', id: action.table.id, key: 'T' + action.table.id, state: action.table }],
    //                state.slice(index + 1)
    //            );
    //
    //        return _.union(
    //            state.slice(0, index + 1),
    //            _.map(action.fields, function (field) {
    //                return { type: 'field', id: field.id, key: 'F' + field.id, state: field };
    //            }),
    //            _.map(action.chapters, function (chapter) {
    //                return { type: 'chapter', id: chapter.id, key: 'C' + chapter.id, state: chapter };
    //            }),
    //            state.slice(index + 1)
    //        );
    //
    //    case 'CLOSE_CHAPTER':
    //
    //        index = _.findIndex(state, { key: 'C' + action.id });
    //
    //        return _.union(
    //            state.slice(0, index + 1),
    //            state.slice(index + 1 + action.count)
    //        );
    //
    //    case 'SCROLL_CHAPTER':
    //        index = _.findIndex(state, { key: 'C' + action.id });
    //        return _.union(
    //            state.slice(0, index + 1),
    //            _.map(action.fields, function (field) {
    //                return { type: 'field', id: field.id, key: 'F' + field.id, state: field };
    //            }),
    //            _.map(action.chapters, function (chapter) {
    //                return { type: 'chapter', id: chapter.id, key: 'C' + chapter.id, state: chapter };
    //            }),
    //            state.slice(index + 1)
    //        );
    //
    //    case 'FEED_FIELD_SOURCE_STATUS':
    //    case 'TOGGLE_CHAPTER_EDITION':
    //    case 'FEED_FIELD_VALUES':
    //    case 'FEED_VERIFIED_FIELDS':
    //    case 'FEED_OVERRIDEN_FIELD':
    //
    //        return state.concat([]);
    }

    return state;
};
