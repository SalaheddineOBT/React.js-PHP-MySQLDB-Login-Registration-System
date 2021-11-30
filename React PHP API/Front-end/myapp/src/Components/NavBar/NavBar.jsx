import React, { Component } from "react";
import {NavLink} from "react-router-dom";

export default class NavBar extends Component{
    render() {
        return (
            <nav>
                <div></div>
                <ul>
                    <li><NavLink className="first" to="/">Login</NavLink></li>
                    <li><NavLink className="secnde" to="/Register">Register</NavLink></li>
                </ul>
            </nav>
        )
    }
}