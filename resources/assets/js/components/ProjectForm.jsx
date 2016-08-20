import React from 'react';
import Paper from 'material-ui/lib/paper';
import TextField from 'material-ui/lib/text-field';
import RaisedButton from 'material-ui/lib/raised-button';
import FlatButton from 'material-ui/lib/flat-button';
import {Link} from 'react-router';
import {History} from 'react-router'
import Firebase from 'firebase';
import ReactFireMixin from 'reactfire';
import AutoComplete from 'material-ui/lib/auto-complete';
import Snackbar from 'material-ui/lib/snackbar';
import IconInfo from 'material-ui/lib/svg-icons/action/info';

import Colors from 'material-ui/lib/styles/colors';

const AvatarColors = ["green","red","blue","yellow","pink","purple","indigo","cyan","teal","lime","amber",
	"orange","deepOrange","deepPurple"];

const ProjectForm = React.createClass({
	mixins: [ReactFireMixin, History],	
	
	getInitialState: function() {				
	    let state = {
	    	searchText: null,
	    	customers: null, 
	    	acSource: [],
	    	customerToCreate: null,
	    	snackbarOpen: false, snackbarText: "",
	    	project: {".key": null, title: null, description: "", customer: null, color: null},
	    	titleText: "",
	    	customerFieldNote: "",
	    	customerFieldColor: Colors.grey300,
	    	customerFieldStyle: {},	    	
	    };
	    return state;
	},
	componentWillMount: function() {	
	
		let refCustomers = new Firebase("https://materialbasetest.firebaseio.com/Customers");
		this.bindAsArray(refCustomers, "customers");		 	 

		if (this.props.params.id) {
			let projectRef = new Firebase("https://materialbasetest.firebaseio.com/Projects/" + this.props.params.id);
			this.bindAsObject(projectRef, "project");			
			this.setState({titleText: "Úprava projektu"});			
		} else {
			this.state.titleText = "Pridanie projektu";
		}		

	},	
	saveProject: function() {
		let project = this.state.project;

		if (this.state.project.customer == null) {
			// create customer
			let refCustomers = new Firebase("https://materialbasetest.firebaseio.com/Customers");
			let newRef = refCustomers.push({title: this.state.customerToCreate});
			console.log("saved new customer: " + this.state.customer);

			project.customer = newRef.name();			
			this.setState({snackbarText: "Nový zákazník bol uložený.", snackbarOpen: true});
		}
		
		
		if (project[".key"] !== null) {			
			let projectRef = new Firebase("https://materialbasetest.firebaseio.com/Projects/" + project[".key"]);			
			let key = project[".key"];
			delete project[".key"];
			projectRef.set(project);
			project[".key"] = key;
					  	
		  	this.setState({snackbarText: "Projekt bol úspešne aktualizovaný.", snackbarOpen: true});
		  	this.handleUpdateInput(this.state.searchText);
		} else {
			let refProjects = new Firebase("https://materialbasetest.firebaseio.com/Projects");			
			project["color"] = AvatarColors[Math.floor(Math.random() * AvatarColors.length)] + "500";

			delete project[".key"];
		  	let newRef = refProjects.push(project);
		  	project[".key"] = newRef.key();		  	
		  			  	
		  	this.setState({snackbarText: "Projekt bol úspešne uložený.", snackbarOpen: true});
		}
		this.setState({project: project});				
	},
	handleChange: function(event) {
		let projectData = this.state.project;
		projectData[event.target.name] = event.target.value
    	this.setState({project: projectData});
  	},
  	handleUpdateInput: function(t) {
  		let project_customer = null;
  		let newacSource = [];
  		let lastCId = null;
		for (let cId in this.state.customers) {
			let customer = this.state.customers[cId];			
			if (customer.title.indexOf(t) > -1) {				
				newacSource.push(customer.title);
				lastCId = customer[".key"];				
			}
		} 
		this.setState({acSource: newacSource});
		
		if (newacSource.indexOf(t) === 0) {			
			project_customer = lastCId;
			console.log("customer selected " + lastCId);
			this.setState({customerFieldNote: "Zákazník " + t + " existuje", customerFieldColor: Colors.green500});
		} else if (newacSource.indexOf(t) === -1) {
			if (t) {
				this.setState({customerToCreate: t});
				console.log("customer must be created");
				this.setState({customerFieldNote: "Zákazník " + t + " bude vytvorený", customerFieldColor: Colors.orange500});				
			}			
		}	
		let project = this.state.project;
		project.customer = project_customer;
		this.setState({project: project});
	},
	handleRequestClose: function() {
	    this.setState({
			snackbarOpen: false,
	    });
	},
	render() {	
		if (this.state.project.customer !== null) {						
			for (let cId in this.state.customers) {
				let c = this.state.customers[cId];
				if (c[".key"] === this.state.project.customer) {					
					this.state.searchText = c.title;
					this.state.customerFieldNote = "Zákazník " + c.title + " existuje";
					this.state.customerFieldColor = Colors.green500;				
				}
			}
		}	
		return (			
			<div>				
				<Paper style={{maxWidth: "800px", margin: "0 auto", padding: "30px"}} zDepth={2}>					
					<form autocomplete="false">
						<h1>{this.state.titleText}</h1>
						<TextField floatingLabelText="Názov projektu" 
							hintText="Tlač. konferencia" name="title" value={this.state.project.title}
							style={{width: "100%"}} onChange={this.handleChange}
							autocomplete="false" />						
						<AutoComplete					       
					        floatingLabelText="Zákazník"
					        hintText="Firma, s.r.o."
					        name="customer" searchText={this.state.searchText}
					        dataSource={this.state.acSource}
					        onUpdateInput={this.handleUpdateInput}
					        onNewRequest={this.handleUpdateInput}
					        filter={AutoComplete.caseInsensitiveFilter}
					        triggerUpdateOnFocus={true}
					        style={{width: "100%"}}
					        underlineStyle={{borderColor: this.state.customerFieldColor}} />
					    <div style={{textAlign: "right", color: this.state.customerFieldColor}}>
					    	{this.state.customerFieldNote}
					    </div>
						<TextField 
							floatingLabelText="Voľné poznámky" name="description" value={this.state.project.description}
							hintText="vybavuje Jakub Lajmon, výnimočné vzťahy"
							style={{width: "100%", fontSize: "100%"}} multiLine={true} rows={2} onChange={this.handleChange}
							autocomplete="false" />				
						<br /><br /><br />
						<div>
							<Link to="projects"><FlatButton label="Späť" /></Link>							
							<RaisedButton label="Ulož" primary={true} onClick={this.saveProject} style={{float: "right"}} />
						</div>						
					</form>					
				</Paper>
				<Snackbar
		          open={this.state.snackbarOpen}
		          message={this.state.snackbarText}
		          autoHideDuration={4000}
		          onRequestClose={this.handleRequestClose}
		          style={{marginBottom: "20px"}} />
			</div>
		);
	},
});

export default ProjectForm;
