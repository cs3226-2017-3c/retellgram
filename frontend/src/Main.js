import React, { Component } from 'react';
import { Grid, Row, Col } from 'react-bootstrap';

import Content from './Content';
import Sidebar from './Sidebar';

class Main extends Component {
  render() {
    return (
      <Grid>
        <Row className="show-grid">
          <Col xs={12} sm={8}><Content/></Col>
          <Col xsHidden><Sidebar/></Col>
        </Row>
      </Grid>
    );
  }
}

export default Main;
