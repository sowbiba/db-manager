var React = require('react');

module.exports = React.createClass({
    displayName: 'workspace.source',

    propTypes: {
        id: React.PropTypes.number.isRequired,
        name: React.PropTypes.string.isRequired,
        host: React.PropTypes.string.isRequired,
        slug: React.PropTypes.string.isRequired,
        type_id: React.PropTypes.number.isRequired,
        type_name: React.PropTypes.string.isRequired
    },

    render: function () {
        var classes = [
            'source',
            'source_type_' + this.props.type_id
        ];

        return (
            <div className={ classes.join(' ') }>
                { this.props.name }
            </div>
        );
    }
});
