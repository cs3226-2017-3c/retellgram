import React from 'react';
import ReactDOM from 'react-dom';
import App from './components';
import Home from './components/Home';
import Detail from './components/Detail';
import Login from './components/Login';
import { Router, Route, IndexRoute, browserHistory } from 'react-router';

import './index.css';

ReactDOM.render((
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={Home}/>
      <Route path="/login" component={Login}/>
      <Route path="/detail/:imageId" component={Detail}/>
    </Route>
  </Router>
  ),
  document.getElementById('root')
);
