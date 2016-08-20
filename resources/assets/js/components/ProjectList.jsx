import React from 'react';

import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';
import ActionInfo from 'material-ui/lib/svg-icons/action/info';
import Divider from 'material-ui/lib/divider';
import Avatar from 'material-ui/lib/avatar';
import FileFolder from 'material-ui/lib/svg-icons/file/folder';
import ActionAssignment from 'material-ui/lib/svg-icons/action/assignment';
import Colors from 'material-ui/lib/styles/colors';
import EditorInsertChart from 'material-ui/lib/svg-icons/editor/insert-chart';
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

const ProjectList = React.createClass({
	mixins: [ReactFireMixin],		
	
	getInitialState: function() {
		return {projects: [], customers: []};
	},
	componentDidMount: function() {
		console.log('hey!');
		let refProjects = '';
		let self = this;
		axios.get('/projects',{
			withCredentials: true,
		})
		.then(function (response) {
			console.log(response);
			self.state.projects = response.data;
			console.log(">>>>>>>>>>>>>>>" + self.state.projects + "<<<<<<<<<<<<<<<");
		})
		.catch(function (error) {
			console.log(error);
		});
		//let refProjects = new Firebase("https://materialbasetest.firebaseio.com/Projects");
		
		//this.bindAsArray(refProjects, "projects");	
		
		
		},

	componentWillMount: function() {		

		let refCustomers = new Firebase("https://materialbasetest.firebaseio.com/Customers");
		this.bindAsObject(refCustomers, "customers");
	},
	getCustomerTitle: function(cid) {
		if (this.state.customers[cid]) {
			return this.state.customers[cid].title;
		}
	},
	renderProjects(List) {
		console.log(List);
		return List.map((proj) => (			

			 <Link key={proj[".id"]} to={`projects/update/${proj[".id"]}`} style={{textDecoration: "none"}}>
			<ListItem
			leftAvatar={<Avatar backgroundColor={Colors[0]}>{proj.title.charAt(0).toUpperCase()}</Avatar>}
			rightIcon={<ActionInfo />}
			primaryText={proj.title}
			secondaryText="sdad" /></Link>
			)); 
	},

	render() {	
		return (
			<div>	  			 			  			
			<Paper style={{maxWidth: "1000px", margin: "0 auto"}}>
			<List subheader="Aktivne" insetSubheader={true}>
			{this.renderProjects(this.state.projects)}
			</List>				  				    
			</Paper>

			<Link to="projects/new"><FloatingActionButton style={style}>
			<ContentAdd />
			</FloatingActionButton></Link>			    
			</div>
			);
	},
});

export default ProjectList;
