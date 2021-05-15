import React from 'react';
import './login.css'

import { useHistory } from 'react-router-dom';




class Login extends React.Component{
    constructor(props) {
        super(props);
        this.state = {account: '', password: ''};
    }

    OnSubmit = () => {
        window.location.href = "submit"
    }

    onSignUp = () => {
        window.location.href = "signup"

    }

    render(){
        return (
            <div className={"login_in"}>
                <div className="ui placeholder segment">
                    <div className="ui two column very relaxed stackable grid">
                        <div className="column">
                            <div className="ui form">
                                <div className="field">
                                    <label>Username</label>
                                    <div className="ui left icon input">
                                        <input type="text" placeholder="Username" value={this.state.account} onChange={event => this.setState({account: event.target.value})} ></input>
                                        <i className="user icon"> </i>
                                    </div>
                                </div>
                                <div className="field">
                                    <label>Password</label>
                                    <div className="ui left icon input">
                                        <input
                                            type="password"
                                            value={this.state.password}
                                            onChange={(e)=> this.setState({password: e.target.value})}
                                        >
                                        </input>
                                        <i className="lock icon"></i>
                                    </div>
                                </div>
                                <div className="ui blue submit button"  onClick={this.OnSubmit}>Login</div>
                            </div>
                        </div>
                        <div className="middle aligned column">
                            <div className="ui big button" onClick={this.onSignUp}>
                                <i className="signup icon"  ></i>
                                Sign Up
                            </div>
                        </div>
                    </div>
                    <div className="ui vertical divider">
                        Or
                    </div>

                </div>
            </div>
        );
    }
}

export default Login;