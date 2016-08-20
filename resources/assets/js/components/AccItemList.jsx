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

const AccItemList = React.createClass({
	mixins: [ReactFireMixin],		
	
	getInitialState: function() {
	    return {AccItems: []};
	  },
	componentWillMount: function() {		
	  let refProjects = new Firebase("https://materialbasetest.firebaseio.com/AccItems");
	  this.bindAsArray(refProjects, "AccItems");	  	  	 
	},	
	renderAccItems(List) {
		return List.map((AccItem) => (			
				<Link key={AccItem[".key"]} to={`AccItems/update/${AccItem[".key"]}`} style={{textDecoration: "none"}}>
				<ListItem
			        leftAvatar={<Avatar backgroundColor={Colors[AccItem.color]}>{AccItem.title.charAt(0).toUpperCase()}</Avatar>}
			        rightIcon={<ActionInfo />}
			        primaryText={AccItem.title} /></Link>
		)); 
	},

	render() {	
	  return (
	  		<div>	  			 			  			
	  			<Paper style={{maxWidth: "1000px", margin: "0 auto"}}>
				    <List>
				      {this.renderAccItems(this.state.AccItems)}
				    </List>				  				    
				</Paper>
				
				<Link to="AccItems/new"><FloatingActionButton style={style}>
			      <ContentAdd />
			    </FloatingActionButton></Link>			    
		    </div>
		);
	},
});

export default AccItemList;
