import React, { Component } from "react";

export default class Home extends Component{
    render() {
        const d=new Date();
        return (
            <div className="home">
                <div>
                    <h1>Welcome <span className="name">{this.props.name}</span></h1>
                    <button className="btns" onClick={()=>this.props.logout()}>Logout</button>
                </div>
                <footer>&copy; 2020 - {d.getFullYear()} | Salaheddine Solicode</footer>
            </div>
        )
    }
}