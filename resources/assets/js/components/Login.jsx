import React from 'react';
import Paper from 'material-ui/lib/paper';
import TextField from 'material-ui/lib/text-field';
import RaisedButton from 'material-ui/lib/raised-button';
import FlatButton from 'material-ui/lib/flat-button';
import {Link} from 'react-router';
import {History} from 'react-router'
import Firebase from 'firebase';
import ReactFireMixin from 'reactfire';
import Snackbar from 'material-ui/lib/snackbar';
import IconInfo from 'material-ui/lib/svg-icons/action/info';

import Colors from 'material-ui/lib/styles/colors';

const AvatarColors = ["green","red","blue","yellow","pink","purple","indigo","cyan","teal","lime","amber",
	"orange","deepOrange","deepPurple"];

const Login = React.createClass({
	mixins: [ReactFireMixin, History],	
	
	getInitialState: function() {				
	    let state = {	    	
	    	snackbarOpen: false, snackbarText: "",
	    	user: {email: "", password: null},
	    };
	    return state;
	},	
	login: function() {
		alert(this.state.user.email + " " + this.state.user.password);
	},	
	handleChange: function(event) {
		let user = this.state.user;
		user[event.target.name] = event.target.value
    	this.setState({user: user});
  	},
	handleRequestClose: function() {
	    this.setState({
			snackbarOpen: false,
	    });
	},
	render() {			
		return (			
			<div>				
				<Paper style={{maxWidth: "400px", margin: "50px auto", padding: "30px"}} zDepth={2}>					
					<form autocomplete="false">	
						<h1>Prihlásenie</h1>					
						<TextField floatingLabelText="Email" 
							hintText="jan.novak@gmail.com" name="email"
							style={{width: "100%"}} onChange={this.handleChange}
							autocomplete="false" />										
						<TextField floatingLabelText="Heslo" 
							hintText="********" name="password"
							style={{width: "100%"}} onChange={this.handleChange} type="password"
							autocomplete="false" />					
						<br /><br /><br />
						<div>							
							<RaisedButton label="Prihlásiť" primary={true} onClick={this.login} style={{float: "right"}} />
						</div>
						<br />						
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

export default Login;
