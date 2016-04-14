var React = require('react');
var actions = require('../store/actions');
var Redux = require('react-redux');

var Sources = require('./workspace/sources');
var Targets = require('./workspace/targets');


var component = React.createClass({
    displayName: 'workspace',

    propTypes: {
        sources: React.PropTypes.array,
        targets: React.PropTypes.array
    },

    computeClass: function() {
        return [
            'row',
            'operations-workspace'
        ].join(' ');
    },

    render: function () {
        if (! this.props.sources)
            return (
                <p className="revision-loading">
                Chargement en cours...
                </p>
            );

        return (
            <div className={ this.computeClass() }>
                <div className="col-xs-5 left operations-sources-list">
                    <Sources sources={ this.props.sources }/>
                </div>
                <div className="col-xs-5 right operations-targets-list">
                    <Targets targets={ this.props.targets }/>
                </div>
            </div>
        );
    }
});

var connect = Redux.connect(
    function (state) {
        return {
            sources: state.workspace.sources,
            targets: state.workspace.targets
        };
    }
);

module.exports = connect(component);
