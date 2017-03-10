import React, { Component } from 'react';
import { Nav, Navbar, NavItem } from 'react-bootstrap';
import { LinkContainer } from 'react-router-bootstrap';

class Navi extends Component {
  render() {
    return (
      <Navbar>
         <Navbar.Header>
           <Navbar.Brand>
             Retellgram
           </Navbar.Brand>
         </Navbar.Header>
         <Nav>
           <LinkContainer to="/">
             <NavItem eventKey={1}>Home</NavItem>
           </LinkContainer>
           <LinkContainer to="/login">
             <NavItem eventKey={2}>Login</NavItem>
           </LinkContainer>
         </Nav>
       </Navbar>
    );
  }
}

export default Navi;
