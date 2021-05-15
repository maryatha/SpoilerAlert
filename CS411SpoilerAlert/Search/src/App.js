import React from 'react';
import './App.css';
import Login from "./login/login";
import Signup from "./login/signup";
import SearchBarFunc from "./search/search";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from "react-router-dom";
function App() {
  return (
      <Router>
          <div>
              <Switch>
                  <Route path="/login">
                      <Login />
                  </Route>
                  <Route path="/signup">
                      <Signup />
                  </Route>
                  <Route path="/">
                      <Home />
                  </Route>
                  <Route path="/submit">
                      <Mainpage />
                  </Route>

              </Switch>

          </div>
      </Router>
  );
}

function Home() {
    return <div><SearchBarFunc/></div>
}

function Mainpage() {
    return <div><SearchBarFunc/></div>
}

export default App;
