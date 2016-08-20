'use strict';

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _reactDom = require('react-dom');

var _reactDom2 = _interopRequireDefault(_reactDom);

var _reactTapEventPlugin = require('react-tap-event-plugin');

var _reactTapEventPlugin2 = _interopRequireDefault(_reactTapEventPlugin);

var _history = require('history');

var _reactRouter = require('react-router');

var _Layout = require('./components/Layout');

var _Layout2 = _interopRequireDefault(_Layout);

var _Login = require('./components/Login');

var _Login2 = _interopRequireDefault(_Login);

var _ProjectList = require('./components/ProjectList');

var _ProjectList2 = _interopRequireDefault(_ProjectList);

var _ProjectDetail = require('./components/ProjectDetail');

var _ProjectDetail2 = _interopRequireDefault(_ProjectDetail);

var _ProjectForm = require('./components/ProjectForm');

var _ProjectForm2 = _interopRequireDefault(_ProjectForm);

var _UserList = require('./components/UserList');

var _UserList2 = _interopRequireDefault(_UserList);

var _UserForm = require('./components/UserForm');

var _UserForm2 = _interopRequireDefault(_UserForm);

var _AccItemList = require('./components/AccItemList');

var _AccItemList2 = _interopRequireDefault(_AccItemList);

var _AccItemForm = require('./components/AccItemForm');

var _AccItemForm2 = _interopRequireDefault(_AccItemForm);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

//Needed for onTouchTap
//Can go away when react 1.0 release
//Check this repo:
//https://github.com/zilverline/react-tap-event-plugin
// Our custom react component
(0, _reactTapEventPlugin2.default)();

var history = (0, _history.createHashHistory)();

var unlisten = history.listen(function (location) {
  var trackingPath = location.pathname;
  if (trackingPath.startsWith("/")) {
    // track only if pathame starts with slash, because if not, reouter will redirect to path, starting with slash
    var pathParts = trackingPath.split("/");
    // keep only first two blocks of path (remove entity ID)
    if (pathParts[2] === "update") {
      trackingPath = pathParts[0] + "/" + pathParts[1] + "/" + pathParts[2];
    }

    console.log("GA tracked pageview: " + trackingPath);
    ga('send', 'pageview', trackingPath);

    // INSPECTLET
    __insp.push(["pageUrl", trackingPath]);
    __insp.push(["virtualPage"]);
    //__insp.push(['tagSession', {email: "john@example.com"}]); // push custom meta data
    //__insp.push(['tagSession', "viewed checkout"]);  // push tag to session
  }
});

// Render the main app react component into the app div.
// For more details see: https://facebook.github.io/react/docs/top-level-api.html#react.render

_reactDom2.default.render(_react2.default.createElement(
  _reactRouter.Router,
  { history: history },
  _react2.default.createElement(
    _reactRouter.Route,
    { component: _Layout2.default },
    _react2.default.createElement(_reactRouter.Route, { path: 'login', component: _Login2.default }),
    _react2.default.createElement(
      _reactRouter.Route,
      { path: 'projects' },
      _react2.default.createElement(_reactRouter.IndexRoute, { component: _ProjectList2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'new', component: _ProjectForm2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'update/:id', component: _ProjectForm2.default })
    ),
    _react2.default.createElement(
      _reactRouter.Route,
      { path: 'users' },
      _react2.default.createElement(_reactRouter.IndexRoute, { component: _UserList2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'new', component: _UserForm2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'update/:id', component: _UserForm2.default })
    ),
    _react2.default.createElement(
      _reactRouter.Route,
      { path: 'accitems' },
      _react2.default.createElement(_reactRouter.IndexRoute, { component: _AccItemList2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'new', component: _AccItemForm2.default }),
      _react2.default.createElement(_reactRouter.Route, { path: 'update/:id', component: _AccItemForm2.default })
    ),
    _react2.default.createElement(_reactRouter.Redirect, { from: '/', to: 'projects' })
  )
), document.getElementById('app'));
//# sourceMappingURL=all.js.map
