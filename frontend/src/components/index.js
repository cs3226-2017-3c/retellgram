import React, { Component } from 'react';

import Navi from './Navi';

class App extends Component {
  render() {
    return (
      <div>
        <Navi/>
        {this.props.children}
      </div>
    );
  }
}

export default App;
