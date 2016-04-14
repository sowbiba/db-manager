var React = require('react');

module.exports = React.createClass({
    displayName: 'workspace.target',

    propTypes: {
        id: React.PropTypes.number.isRequired,
        name: React.PropTypes.string.isRequired,
        host: React.PropTypes.string.isRequired,
        slug: React.PropTypes.string.isRequired
    },

    render: function () {
        var classes = [
            'target',
            'target_type_' + this.props.type_id
        ];

        return (
            <div className={ classes.join(' ') }>
                { this.props.name }
            </div>
        );
    }
});
