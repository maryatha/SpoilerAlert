import React from 'react'
import './signup.css'
const a =( )=> {
    return (
        <div className="ui segment">
            <div className="ui two column very relaxed grid">
                <div className="column">
                    <h1>Sign up.</h1>
                    <p>Give us some of your information to get free access field</p>

                    <div className="ui equal width form">
                        <div className="field">
                            <label>Username</label>
                            <input type="text" placeholder="Username"></input>
                        </div>

                        <div className="field">
                            <label>E-mail</label>
                            <input type="email" placeholder="joe@schmoe.com"></input>
                        </div>

                        <div className="field">
                            <label>Password</label>
                            <input type="password"></input>
                        </div>
                    </div>
                </div>
                <div className="column">
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                </div>
            </div>
            <div className="ui vertical divider">
                and
            </div>
        </div>
    );
}

class Signup extends React.Component{
    constructor(pros) {
        super(pros);
        this.state = {checked: false};
    }

    checkbox=(e) =>{
        this.setState({checked: e.target.checked});
    }

    render(){
        return (
            <div className="ui segment">
                <div className="ui two column very relaxed grid">
                    <div className="column">
                        <h1>Sign up.</h1>
                        <p>Give us some of your information to get free access field</p>

                        <div className="ui equal width form ">
                            <div className="field">
                                <label>Username</label>
                                <input type="text" placeholder="Username"></input>
                            </div>

                            <div className="field">
                                <label>E-mail</label>
                                <input type="email" placeholder="joe@schmoe.com"></input>
                            </div>

                            <div className="field">
                                <label>Password</label>
                                <input type="password"></input>
                            </div>
                            <div className="ui checked checkbox">
                                <input type="checkbox" checked= {this.state.checked} onChange={e => {
                                    this.setState({checked: e.target.checked});
                                }}></input>
                                    <label>By creating an account you agree to the term of use and privacy policy</label>
                            </div>
                            <p></p>
                            <div className="ui fluid large purple submit button">Create account</div>
                            <p></p>

                            <p className={"a1"}>Already have an account? <u className={"a2"} onClick={()=>{window.location.href = '/login'}}>Log in</u> </p>

                        </div>
                    </div>
                    <div className="column">
                       <img class="ui fluid image"
                            src = "https://images.unsplash.com/photo-1615041359204-45a4dff5ec92?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80"/>
                    </div>
                </div>
                <div className="ui vertical divider">

                </div>
            </div>
        );
    }




}

export default Signup;