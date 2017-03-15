import React, { Component } from 'react';
import { Link } from 'react-router';
import { Nav, Navbar, NavItem } from 'react-bootstrap';
import { LinkContainer } from 'react-router-bootstrap';

class Navi extends Component {
  render() {
    return (
      <Navbar collapseOnSelect>
         <Navbar.Header>
           <Navbar.Brand>
            <Link to="/">
              Retellgram
             </Link>
           </Navbar.Brand>
           <Navbar.Toggle />
         </Navbar.Header>
         <Navbar.Collapse>
           <Nav>
             <LinkContainer to="/login">
               <NavItem eventKey={2}>Login</NavItem>
             </LinkContainer>
           </Nav>
         </Navbar.Collapse>
       </Navbar>
    );
  }
}

export default Navi;
