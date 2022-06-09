import { useState } from 'react';
import $ from 'jquery';
import '../styles/login.scss'
import { useNavigate } from 'react-router-dom';
// import { useEffect } from 'react';

// var http = require('http');
// var mysql = require('mysql');
// const [userInfo,setUserInfo] = useState({}); // object


// var con = mysql.createConnection({
    //     host: "localhost",
    //     user: "root",
    //     password: "",
    //     database: "travel_db"
    // })
    
    const UserInfo = () => {
    const navigate = useNavigate();
    const [username, setUserName] = useState("");
    const [password, setPassword] = useState("");
    
    const handleSubmit = (event) => {
        const form = $(event.target);
        $.ajax({ // USERNAME
            type: "POST",
            url: 'http://localhost/php_finalproject/login.php',
            data: form.serialize(),
            success(data){
                setUserName(data);
            }
            // useEffect = (()=>{
            //     [username, password];
            // });
        })
    }

    function goToReg(){
        navigate("/register");
    }

    return(
        <>
            <div className="login-wrap">
                <div className="login-form">
                    {/* <h3>WELCOME TO REJ Airline</h3> */}
                    <form action='http://localhost/php_finalproject/login.php' method='POST' onSubmit={(event)=>handleSubmit(event)}>
                        <label for="username">USERNAME</label>
                        <input type="text" name="username" placeholder="YOUR USERNAME" onChange={(e) => setUserName(e.target.value) } /><br/>

                        <label for="username">PASSWORD</label>
                        <input type="password" name="password" placeholder="YOUR PASSWORD" onChange={(e) => setPassword(e.target.value)} /><br/>
                        <div className="button">
                            <button type="submit" className="btn btn-login" name="login">LOGIN</button>
                            <button className="btn btn-newAccount" onClick={goToReg}>Create an Account</button> 
                        </div>
                    </form>
                </div>
            </div>
        </>
    )
}

export default UserInfo;