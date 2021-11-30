import Login from './Components/Login/Login';
import Register from './Components/Register/Resgister';
import Home from './Components/Home/Home';
import NavBar from './Components/NavBar/NavBar';
import {BrowserRouter,Route,Routes} from "react-router-dom";
import React,{ useState } from 'react';
import axios from 'axios';

function App() {

  const user={
      email:'',
      password:'',
      name:''
  };

  const [Val,setVal]=useState(user);
  const [Err,setErr]=useState({message:""});
  const [pp,setP]=useState(p);

  const logout=()=>{
    setErr({message:''});
    setVal({email:'',password:''});
    setP({user:'',name:''});
  }

  const LoadData=async(dt)=>{
    const log=await axios.post("http://localhost/apiPhp/Login.php",dt);
    return log.data;
  }

  const Homing=async (val)=>{
    const info=await axios.post("http://localhost/apiPhp/Home.php",val);
    return info.data;
  }

  const logining=async (del)=>{
    const l=await LoadData(del);
    if(l[0].Code){
      setP({...pp,user:l[0].user});
      const h=await Homing({user:l[0].user});
      if(h[0].Code){
        setVal({email:del.email,password:del.password,name:h[0].User});
      }else{
        setErr({message:h[0].Message});
      }
    }else{
      setErr({message:l[0].Message});
    }
  }
    
  return (
      <div>
        {
        (!Val.email && !Val.password && !Val.name) ?
        (
          <BrowserRouter>
            <NavBar />
              <div className="App">
                <div className="container">
                  <Routes>
                      <Route path="/Register" element={<Register />} />
                      <Route exact path="/" element={<Login logined={logining} Err={Err} />} />
                  </Routes>
                </div>
              </div>
          </BrowserRouter>

        ) : (
          <Home logout={logout} name={Val.name} />
        )

      }
      </div>
  );
}

export default App;