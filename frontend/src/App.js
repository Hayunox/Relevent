import React, { Component } from 'react';
import './App.css';

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {showWarning: true}
        this.handleToggleClick = this.handleToggleClick.bind(this);
    }

    handleToggleClick() {
        this.setState(prevState => ({
            showWarning: !prevState.showWarning
        }));
    }

  render() {
    return (
        <div class="ui raised very padded text container segment">
            <div class="ui attached message">
                <div class="header">
                    Welcome to ProjetX !
                </div>
                <p>Fill out the form below to sign-up for a new account</p>
                <br/>
                <form class="ui form">
                    <div class="field">
                        <label>Nickname</label>
                        <input name="nickname" value="" type="text"/>
                    </div>
                    <div class="field">
                        <label>E-mail</label>
                        <input name="email" value="" type="text"/>
                    </div>

                    <div class="two fields">
                        <div class="field">
                            <label>Password</label>
                            <input name="password" value="" type="password"/>
                        </div>
                        <div class="field">
                            <label>Password confirm</label>
                            <input name="password-confirm" value="" type="password"/>
                        </div>
                    </div>

                    <div class="ui submit button">Submit</div>
                    <div class="ui error message"></div>
                </form>
            </div>
            <div class="ui bottom attached warning message">
                <i class="icon help"></i>
                Already signed up? <a href="#">Login here</a> instead.
            </div>
        </div>
    );
  }
}

export default App;
