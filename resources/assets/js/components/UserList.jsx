import React from 'react';

import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';
import ActionInfo from 'material-ui/lib/svg-icons/action/info';
import Divider from 'material-ui/lib/divider';
import Avatar from 'material-ui/lib/avatar';
import Colors from 'material-ui/lib/styles/colors';
import {Link} from 'react-router';
import Firebase from 'firebase';
import ReactFireMixin from 'reactfire';
import FloatingActionButton from 'material-ui/lib/floating-action-button';
import ContentAdd from 'material-ui/lib/svg-icons/content/add';
import Paper from 'material-ui/lib/paper';

const style = {  
  float: "right",
  position: "fixed",
  bottom: "20px",
  right: "20px",
};

const UserList = React.createClass({
	mixins: [ReactFireMixin],		
	
	getInitialState: function() {
	    return {users: []};
	  },
	componentWillMount: function() {		
	  let refProjects = new Firebase("https://materialbasetest.firebaseio.com/Users");
	  this.bindAsArray(refProjects, "users");	  	  	 
	},	
	getUserFullName: function(user) {
		return user.firstName + " " + user.lastName;
	},
	renderUsers(List) {
		return List.map((user) => (			
				<Link key={user[".key"]} to={`users/update/${user[".key"]}`} style={{textDecoration: "none"}}>
				<ListItem
			        leftAvatar={<Avatar backgroundColor={Colors[user.color]}>
			        	{user.firstName.charAt(0).toUpperCase()}{user.lastName.charAt(0).toUpperCase()}</Avatar>}
			        rightIcon={<ActionInfo />}
			        primaryText={this.getUserFullName(user)}
			        secondaryText={user.email} /></Link>
		)); 
	},

	render() {	
	  return (
	  		<div>	  			 			  			
	  			<Paper style={{maxWidth: "1000px", margin: "0 auto"}}>
				    <List>
				      {this.renderUsers(this.state.users)}
				    </List>				  				    
				</Paper>
				
				<Link to="users/new"><FloatingActionButton style={style}>
			      <ContentAdd />
			    </FloatingActionButton></Link>			    
		    </div>
		);
	},
});

export default UserList;
