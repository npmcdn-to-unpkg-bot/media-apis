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

const AccItemForm = React.createClass({
	mixins: [ReactFireMixin, History],	
	
	getInitialState: function() {				
	    let state = {
	    	searchText: null,	    		    	
	    	snackbarOpen: false, snackbarText: "",
	    	AccItem: {".key": null, title: "", color: null},
	    	titleText: "",	    	
	    };
	    return state;
	},
	componentWillMount: function() {					
		if (this.props.params.id) {
			let AccItemRef = new Firebase("https://materialbasetest.firebaseio.com/AccItems/" + this.props.params.id);
			this.bindAsObject(AccItemRef, "AccItem");			
			this.setState({titleText: "Úprava položky"});			
		} else {
			this.state.titleText = "Pridanie položky";
		}		

	},	
	saveAccItem: function() {
		let AccItem = this.state.AccItem;		
		
		if (AccItem[".key"] !== null) {			
			let AccItemRef = new Firebase("https://materialbasetest.firebaseio.com/AccItems/" + AccItem[".key"]);			
			let key = AccItem[".key"];
			delete AccItem[".key"];
			AccItemRef.set(AccItem);
			AccItem[".key"] = key;
					  	
		  	this.setState({snackbarText: "Položka bola úspešne aktualizovaná.", snackbarOpen: true});		  	
		} else {
			let refAccItems = new Firebase("https://materialbasetest.firebaseio.com/AccItems");			
			AccItem["color"] = AvatarColors[Math.floor(Math.random() * AvatarColors.length)] + "500";

			delete AccItem[".key"];
		  	let newRef = refAccItems.push(AccItem);
		  	AccItem[".key"] = newRef.key();		  	
		  			  	
		  	this.setState({snackbarText: "Položka bola úspešne uložená.", snackbarOpen: true});
		}
		this.setState({AccItem: AccItem});				
	},
	handleChange: function(event) {
		let AccItemData = this.state.AccItem;
		AccItemData[event.target.name] = event.target.value
    	this.setState({AccItem: AccItemData});
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
						<TextField floatingLabelText="Názov" 
							hintText="príprava tlač. konferencie" name="title" value={this.state.AccItem.title}
							style={{width: "100%"}} onChange={this.handleChange}
							autocomplete="false" />										
						<TextField 
							floatingLabelText="Voľné poznámky" name="description" value={this.state.AccItem.description}
							hintText="dobrá marža, bez ďalších poplatkov atd."
							style={{width: "100%", fontSize: "100%"}} multiLine={true} rows={2} onChange={this.handleChange}
							autocomplete="false" />				
						<br /><br /><br />
						<div>
							<Link to="AccItems"><FlatButton label="Späť" /></Link>							
							<RaisedButton label="Ulož" primary={true} onClick={this.saveAccItem} style={{float: "right"}} />
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

export default AccItemForm;
