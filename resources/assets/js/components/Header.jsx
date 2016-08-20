import React from 'react';
import AppBar from 'material-ui/lib/app-bar';
import {Link} from 'react-router';
import {History} from 'react-router';

const Header = React.createClass({
	mixins: [History],
	handleTouchTap: function() {
		this.history.pushState(null, '/projects');
	},
	render() {
		return <AppBar {...this.props} title={this.props.title} onTitleTouchTap={this.handleTouchTap} />;
	},
});


export default Header;