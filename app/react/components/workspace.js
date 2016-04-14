var React = require('react');
var actions = require('../store/actions');
var connect = require('react-redux').connect;

var connector = connect(
    function (state) {
        return {
            loaded: state.loaded,
            sources: state.sources,
            targets: state.targets
        };
    }
);

module.exports = connector(React.createClass({
    displayName: 'workspace',

    propTypes: {
        loaded: React.PropTypes.bool.isRequired,
        sources: React.PropTypes.object.isRequired,
        targets: React.PropTypes.object.isRequired
    },

    computeClass: function() {
        return [
            'row',
            'operations-workspace'
        ].join(' ');
    },

    render: function () {
        if (! this.props.loaded)
            return (
                <p className="operations-loading">
                Chargement en cours...
                </p>
            );

        return (
            <div className={ this.computeClass() }>
                <div className="col-xs-5 left operations-sources-list"></div>
                <div className="col-xs-5 right operations-targets-list"></div>
            </div>
        );
    }
}));
