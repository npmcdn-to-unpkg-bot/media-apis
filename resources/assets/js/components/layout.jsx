/** In this file, we create a React component which incorporates components provided by material-ui */
import React from 'react';
import Header from './Header';

import LeftNav from 'material-ui/lib/left-nav';
import MenuItem from 'material-ui/lib/menus/menu-item';
import {Link} from 'react-router';

import Card from 'material-ui/lib/card/card';
import CardActions from 'material-ui/lib/card/card-actions';
import CardMedia from 'material-ui/lib/card/card-media';
import CardTitle from 'material-ui/lib/card/card-title';

import IconButton from 'material-ui/lib/icon-button';
import NavigationMenu from 'material-ui/lib/svg-icons/navigation/menu';


const Layout = React.createClass({
  getInitialState: function() {
  	return {
  		open: false,
  	};
  },
  handleToggle: function() {
  	this.setState({open: !this.state.open});
  },
  handleClose: function() {
    this.setState({open: false});
  },
  render: function() {
    return ( 
    	<div>
    		<Header title="Interný systém" iconElementLeft={<IconButton onTouchTap={this.handleToggle}><NavigationMenu /></IconButton>} />	    
    	    <div>    	    	    	
		        <LeftNav open={this.state.open}>
		        	<Card onTouchTap={this.handleToggle}>
					    <CardMedia
					      overlay={<CardTitle title="Slavo Šikuda" subtitle="" />} >
					      <img src="http://lorempixel.com/600/337/abstract/" />
					    </CardMedia>					    
					</Card>
				  <br />
		          <Link to="projects" onTouchTap={this.handleClose}><MenuItem>Projekty</MenuItem></Link>
              <Link to="users" onTouchTap={this.handleClose}><MenuItem>Užívatelia</MenuItem></Link>
              <Link to="AccItems" onTouchTap={this.handleClose}><MenuItem>Položky</MenuItem></Link>
		        </LeftNav>
        		{this.props.children}
        	</div>
       	</div>        
    );
  },
});

export default Layout;
