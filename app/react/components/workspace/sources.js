var React = require('react');

var Source = require('./source');

module.exports = React.createClass({
    displayName: 'workspace.sources',

    propTypes: {
        sources: React.PropTypes.array.isRequired
    },

    render: function () {
        return <div> { this.props.sources.map(this.renderSource) } </div>;
    },

    renderSource: function(source) {
        return (
            <Source key={"source" + source.id} { ... source}></Source>
        );
    }
});
