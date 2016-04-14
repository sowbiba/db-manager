var React = require('react');

var Target = require('./target');

module.exports = React.createClass({
    displayName: 'workspace.targets',

    propTypes: {
        targets: React.PropTypes.array.isRequired
    },

    render: function () {
        return <div> { this.props.targets.map(this.renderTarget) } </div>;
    },

    renderTarget: function(target) {
        return (
            <Target key={"target" + target.id} { ... target}></Target>
        );
    }
});
