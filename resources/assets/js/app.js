import React from 'react';
import ReactDOM from 'react-dom';
import injectTapEventPlugin from 'react-tap-event-plugin';
import {createHashHistory} from 'history';
import {Router, Route, IndexRoute, Redirect} from 'react-router';


import Layout from './components/Layout'; // Our custom react component
import Login from './components/Login';
import ProjectList from './components/ProjectList';
import ProjectDetail from './components/ProjectDetail';
import ProjectForm from './components/ProjectForm';
import UserList from './components/UserList';
import UserForm from './components/UserForm';
import AccItemList from './components/AccItemList';
import AccItemForm from './components/AccItemForm';

//Needed for onTouchTap
//Can go away when react 1.0 release
//Check this repo:
//https://github.com/zilverline/react-tap-event-plugin
injectTapEventPlugin();

let history = createHashHistory();

const unlisten = history.listen(location => {
  let trackingPath = location.pathname;
  if (trackingPath.startsWith("/")) {
    // track only if pathame starts with slash, because if not, reouter will redirect to path, starting with slash
    let pathParts = trackingPath.split("/");
    // keep only first two blocks of path (remove entity ID)
    if (pathParts[2] === "update"){
      trackingPath = pathParts[0] + "/" + pathParts[1] + "/" + pathParts[2];
    }

    console.log("GA tracked pageview: " + trackingPath);
    //ga('send', 'pageview', trackingPath);  
    
    // INSPECTLET
    __insp.push(["pageUrl", trackingPath]);
    __insp.push(["virtualPage"]);
    //__insp.push(['tagSession', {email: "john@example.com"}]); // push custom meta data
    //__insp.push(['tagSession', "viewed checkout"]);  // push tag to session
  }
});

// Render the main app react component into the app div.
// For more details see: https://facebook.github.io/react/docs/top-level-api.html#react.render

ReactDOM.render((
  <Router history={history}>
    <Route component={Layout}>
      <Route path="login" component={Login} />     
      <Route path="projects">                       
        <IndexRoute component={ProjectList} />          
        <Route path="new" component={ProjectForm} />
        <Route path="update/:id" component={ProjectForm} />
        </Route>
      <Route path="users">               
        <IndexRoute component={UserList} />      
        <Route path="new" component={UserForm} />
        <Route path="update/:id" component={UserForm} />
      </Route>
      <Route path="accitems">               
        <IndexRoute component={AccItemList} />      
        <Route path="new" component={AccItemForm} />
        <Route path="update/:id" component={AccItemForm} />
      </Route>
      <Redirect from="/" to="projects"/>
    </Route>
  </Router>
), document.getElementById('app'));