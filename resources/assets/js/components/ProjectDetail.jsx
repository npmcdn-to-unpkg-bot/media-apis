import React from 'react';
import Paper from 'material-ui/lib/Paper';
import ReactDataGrid from 'react-data-grid/addons';



//options for priorities autocomplete editor
let priorities = [{id:0, title : 'Critical'}, {id:1, title : 'High'}, {id:2, title : 'Medium'}, {id:3, title : 'Low'}]
let AutoCompleteEditor = ReactDataGrid.Editors.AutoComplete;
let PrioritiesEditor = <AutoCompleteEditor options={priorities}/>

//options for IssueType dropdown editor
let issueTypes = ['Bug', 'Improvement', 'Epic', 'Story'];
let DropDownEditor = ReactDataGrid.Editors.DropDownEditor;
let IssueTypesEditor = <DropDownEditor options={issueTypes}/>

//helper to generate a random date
function randomDate(start, end) {
  return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime())).toLocaleDateString();
}

//helper to create a fixed number of rows
function createRows(numberOfRows){
  let _rows = [];
  for (let i = 1; i < numberOfRows; i++) {
    _rows.push({
      id: i,
      task: 'Task ' + i,
      complete: Math.min(100, Math.round(Math.random() * 110)),
      priority : ['Critical', 'High', 'Medium', 'Low'][Math.floor((Math.random() * 3) + 1)],
      issueType : issueTypes[Math.floor((Math.random() * 3) + 1)],
      startDate: randomDate(new Date(2015, 3, 1), new Date()),
      completeDate: randomDate(new Date(), new Date(2016, 0, 1)),
    });
  }
  return _rows;
}

//function to retrieve a row for a given index
let rowGetter = function(i){
  return _rows[i];
};

//Columns definition
let columns = [
{
  key: 'id',
  name: 'ID',
  width: 80,
},
{
  key: 'task',
  name: 'Title',
  editable : true,
},
{
  key : 'priority',
  name : 'Priority',
  editor : PrioritiesEditor,
},
{
  key : 'issueType',
  name : 'Issue Type',
  editor : IssueTypesEditor,
},
]



const ProjectDetail = React.createClass({
	getInitialState : function(){
	    return {rows : createRows(10)}
	},

	rowGetter : function(rowIdx){
		return this.state.rows[rowIdx]
	},

	handleRowUpdated : function(e){
	    //merge updated row with current row and rerender by setting state
	    let rows = this.state.rows;
	    Object.assign(rows[e.rowIdx], e.updated);
	    this.setState({rows:rows});
	},

	render: function() {
		return (
			<div>
				<Paper style={{maxWidth: "800px", margin: "0 auto"}}>
					Project: {this.props.params.id}
					<ReactDataGrid
				      enableCellSelect={true}
				      columns={columns}
				      rowGetter={this.rowGetter}
				      rowsCount={this.state.rows.length}
				      minHeight={500}
				      onRowUpdated={this.handleRowUpdated} />
				</Paper>
			</div>
		)
	},
});

export default ProjectDetail;
