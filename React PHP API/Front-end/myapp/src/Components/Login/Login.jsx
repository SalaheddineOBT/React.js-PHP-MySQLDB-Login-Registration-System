import React, { useState} from "react";

export default function Login({logined,Err}) {
    
    const user={
        email:'',
        password:''
    };

    const [Val,setVal]=useState(user);

    const Changer=(e)=>{
        const {name,value}=e.target;
        setVal({...Val,[name]:value});
    }

    const hndlSub=(e)=>{
        e.preventDefault();
        logined(Val);
    };

    return (
        <form onSubmit={hndlSub} className="FormLog">

            <h1>Login Form</h1>

            { (Err.message) ? (<div className="divErr">{Err.message}</div>) : null }

            <label htmlFor="email">Email :</label>
            <input type="email" placeholder="Email" name="email" value={Val.email} onChange={Changer} />
           
            <label htmlFor="password">Password :</label>
            <input type="password" placeholder="Password" name="password" value={Val.password} onChange={Changer} />
            
            <button type="submit" className="btn">Login</button>

        </form>

    )   
}