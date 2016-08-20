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

const UserForm = React.createClass({
	mixins: [ReactFireMixin, History],	
	
	getInitialState: function() {				
	    let state = {
	    	searchText: null,	    		    	
	    	snackbarOpen: false, snackbarText: "",
	    	user: {".key": null, firstName: "", lastName: "", password: "", color: null},
	    	titleText: "",	    	
	    };
	    return state;
	},
	componentWillMount: function() {					
		if (this.props.params.id) {
			let userRef = new Firebase("https://materialbasetest.firebaseio.com/Users/" + this.props.params.id);
			this.bindAsObject(userRef, "user");			
			this.setState({titleText: "Úprava užívateľa"});			
		} else {
			this.state.titleText = "Pridanie užívateľa";
		}		

	},	
	saveuser: function() {
		let user = this.state.user;		
		
		if (user[".key"] !== null) {			
			let userRef = new Firebase("https://materialbasetest.firebaseio.com/Users/" + user[".key"]);			
			let key = user[".key"];
			delete user[".key"];
			userRef.set(user);
			user[".key"] = key;
					  	
		  	this.setState({snackbarText: "Užívateľ bol úspešne aktualizovaný.", snackbarOpen: true});		  	
		} else {
			let refusers = new Firebase("https://materialbasetest.firebaseio.com/Users");			
			user["color"] = AvatarColors[Math.floor(Math.random() * AvatarColors.length)] + "500";

			delete user[".key"];
		  	let newRef = refusers.push(user);
		  	user[".key"] = newRef.key();		  	
		  			  	
		  	this.setState({snackbarText: "Užívateľ bol úspešne uložený.", snackbarOpen: true});
		}
		this.setState({user: user});				
	},
	handleChange: function(event) {
		let userData = this.state.user;
		userData[event.target.name] = event.target.value
    	this.setState({user: userData});
  	},
	handleRequestClose: function() {
	    this.setState({
			snackbarOpen: false,
	    });
	},
	render() {			
		return (			
			<div>				
				<Paper style={{maxWidth: "800px", margin: "0 auto", padding: "30px"}} zDepth={2}>					
					<form autocomplete="false">
						<h1>{this.state.titleText}</h1>
						<TextField floatingLabelText="Meno" 
							hintText="Ján" name="firstName" value={this.state.user.firstName}
							style={{width: "50%"}} onChange={this.handleChange}
							autocomplete="false" />
						<TextField floatingLabelText="Priezvisko" 
							hintText="Novák" name="lastName" value={this.state.user.lastName}
							style={{width: "50%"}} onChange={this.handleChange}
							autocomplete="false" />	
						<TextField floatingLabelText="Email" 
							hintText="jan.novak@gmail.com" name="email" value={this.state.user.email}
							style={{width: "100%"}} onChange={this.handleChange}
							autocomplete="false" />
						<TextField floatingLabelText="Heslo" 
							hintText="********" name="password" value={this.state.user.password}
							style={{width: "100%"}} onChange={this.handleChange} type="password"
							autocomplete="false" />												
						<TextField 
							floatingLabelText="Voľné poznámky" name="description" value={this.state.user.description}
							hintText="veselá povaha, zodpovedný, dobre komunikuje"
							style={{width: "100%", fontSize: "100%"}} multiLine={true} rows={2} onChange={this.handleChange}
							autocomplete="false" />				
						<br /><br /><br />
						<div>
							<Link to="users"><FlatButton label="Späť" /></Link>							
							<RaisedButton label="Ulož" primary={true} onClick={this.saveuser} style={{float: "right"}} />
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

export default UserForm;
