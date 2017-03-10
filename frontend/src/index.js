import React from 'react';
import ReactDOM from 'react-dom';
import Home from './Home';
import Detail from './Detail';
import Login from './Login';
import { Router, Route, browserHistory } from 'react-router'

import './index.css';

ReactDOM.render((
  <Router history={browserHistory}>
    <Route path="/" component={Home}/>
    <Route path="/login" component={Login}/>
    <Route path="/detail/:imageId" component={Detail}/>
  </Router>
  ),
  document.getElementById('root')
);
