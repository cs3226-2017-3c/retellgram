import React, { Component } from 'react';

import Navi from './Navi';
import Main from './Main';

class Home extends Component {
  render() {
    return (
      <div>
        <Navi/>
        <Main/>
      </div>
    );
  }
}

export default Home;
