var React = require('react');

module.exports = React.createClass({
    displayName: 'workspace.source',

    propTypes: {
        id: React.PropTypes.number.isRequired,
        name: React.PropTypes.string.isRequired,
        host: React.PropTypes.string.isRequired,
        slug: React.PropTypes.string.isRequired,
        type_id: React.PropTypes.number.isRequired,
        type_name: React.PropTypes.string.isRequired,
        content: React.PropTypes.arrayOf(React.PropTypes.string).isRequired
    },

    contextTypes: {
        getSourceContent: React.PropTypes.func.isRequired,
        getTargetContent: React.PropTypes.func.isRequired
    },

    getInitialState: function() {
        return {
            open: false
        }
    },

    getSourceContent: function() {
        if (! this.state.open) {
            this.context.getSourceContent(this.props.id, function() {
                console.log('open: true');
                this.setState({ open: true });
            }.bind(this));
        } else {
            this.setState({ open: false });
        }
    },

    renderContent: function() {
        if (! this.state.open)
            return null;

        console.log('snif');
        return (
            <div className="source_content">
                { this.props.content.map(this.renderFile) }
            </div>
        );
    },

    renderFile: function (contentFile) {
        console.log(contentFile);
        return (
          <div>
            { contentFile }
          </div>
        );
    },

    render: function () {
        var classes = [
            'source',
            'source_type_' + this.props.type_id
        ];

        return (
            <div id={ 'source_' + this.props.id }>
                <div className={ classes.join(' ') } onClick={ function() { this.getSourceContent() }.bind(this) }>
                    { this.props.name }
                </div>

                { this.renderContent() }
            </div>
        );
    }
});
