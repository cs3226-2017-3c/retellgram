import React from 'react';
import ReactDOM from 'react-dom';
import { createStore, combineReducers, applyMiddleware } from 'redux'
import { Router, Route, IndexRoute, browserHistory } from 'react-router';
import { Provider } from 'react-redux'
import createLogger from 'redux-logger'
import thunk from 'redux-thunk'
import { syncHistoryWithStore, routerReducer } from 'react-router-redux'

import App from './components';
import Home from './components/Home';
import Detail from './components/Detail';
import Login from './components/Login';

import './index.css';

import reducers from './reducers'

const middleware = [ thunk ]
if (process.env.NODE_ENV !== 'production') {
  middleware.push(createLogger())
}

const store = createStore(
    combineReducers({
    ...reducers,
    routing: routerReducer
  }),
  applyMiddleware(...middleware)
)

const history = syncHistoryWithStore(browserHistory, store)

ReactDOM.render((
  <Provider store={store}>
    <Router history={history}>
      <Route path="/" component={App}>
        <IndexRoute component={Home}/>
        <Route path="/login" component={Login}/>
        <Route path="/detail/:imageId" component={Detail}/>
      </Route>
    </Router>
  </Provider>
  ),
  document.getElementById('root')
);
