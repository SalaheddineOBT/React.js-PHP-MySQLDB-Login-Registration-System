import React, { useState } from "react";
import axios from 'axios';

export default function Register(){

    const data={        
        username:'',
        email:'',
        password:'',
        confirme:''
    };

    const [Val,setVal]=useState(data);
    const [Err,setErr]=useState({});

    const Changer=(e)=>{
        const {name,value}=e.target;
        setVal({...Val,[name]:value});
    }

    const Registered= async (data)=>{
        const reg=await axios.post("http://localhost/apiPhp/Register.php",data);
        return reg.data;
    }

    const hndlSub= async (e) => {
        e.preventDefault();
        let err=[];
        if(Val.password===Val.confirme){
            const reg=await Registered(Val);
            if(reg[0].Code){
                alert(reg[0].Message);
                setErr({Message:""});
            }else{
                err=reg[0].Message;
                setErr({Message:err});
            }
        }else
        setErr({Message:'Confirme Password Incorrect !'});
    };

    return (

        <form onSubmit={hndlSub} className="FormReg">

            <h1>Register Form</h1>

            { (Err.Message) ? (<div className="divErr">{Err.Message}</div>) : null }

            <label htmlFor="username">User Name :</label>
            <input type="text" placeholder="User Name" name="username" value={Val.username} onChange={Changer} />

            <label htmlFor="email">Email :</label>
            <input type="email" placeholder="Email" name="email" value={Val.email} onChange={Changer} />

            <label htmlFor="password">Password :</label>
            <input type="password" placeholder="Password" name="password" value={Val.password} onChange={Changer} />

            <label htmlFor="confirmer password">Confirmer Password :</label>
            <input type="password" placeholder="Confirme Password" name="confirme" value={Val.confirme} onChange={Changer} />

            <button type="submit" className="btn">Click me</button>

        </form>
    )
}