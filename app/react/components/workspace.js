var React = require('react');
var actions = require('../store/actions');
var Redux = require('react-redux');

var Sources = require('./workspace/sources');
var Targets = require('./workspace/targets');


var component = React.createClass({
    displayName: 'workspace',

    childContextTypes: {
        getSourceContent: React.PropTypes.func.isRequired,
        getTargetContent: React.PropTypes.func.isRequired
    },

    propTypes: {
        sources: React.PropTypes.array,
        targets: React.PropTypes.array
    },

    getChildContext: function () {
        return {
            getSourceContent: function(id, callback) { this.props.getSourceContent(id, callback) }.bind(this),
            getTargetContent: function(id, callback) { this.props.getTargetContent(id, callback) }.bind(this)
        }
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
        console.log(state, 'toto');
        return {
            sources: state.workspace.sources,
            targets: state.workspace.targets
        };
    },
    function (dispatch) {
        return {
            getSourceContent: function (id, callback) { dispatch(actions.getSourceContent(id, callback)) },
            getTargetContent: function (id) { dispatch(actions.getTargetContent(id)) }
        };
    }
);

module.exports = connect(component);
