import {useState} from 'react';
import $ from 'jquery';
// import {useForm} from 'react-hook-form'
// import {ErrorMessage} from '@hookform/error-message';
import '../styles/register.scss';

function RegisterForm(){
    const [fname,setFName] = useState("");
    const [lname,setLName] = useState("");
    const [uname,setUName] = useState("");
    const [email,setEmail] = useState("");
    const [pass,setPass] = useState("");
    const [output,setOutput] = useState("");

    const regiSubmit = (event) => {
        const regForm = $(event.target);
        $.ajaxSetup({
            type: "POST",
            url:regForm.attr("action"),
            data: regForm.serialize(),
            success(data){
                setOutput(data);
            }
        });
    }

    return(
        <>
        <div className="reg-wrap">
            <div className="reg-form">
                <h1>REGISTRATION FORM</h1>
                <form method='POST' action='http://localhost/php_finalproject/register.php' onSubmit={(event) => regiSubmit(event)}>
                    <input type="text" name="fname" value={fname} onChange={(event)=>setFName(event.target.value)} placeholder="First Name" required/>
                    <input type="text" name="lname" value={lname} onChange={(event)=>setLName(event.target.value)} placeholder="Last Name" required/>
                    <input type="text" name="uname" value={uname} onChange={(event)=>setUName(event.target.value)} placeholder="User Name" required/>
                    <input type="email" name="email" value={email} onChange={(event)=>setEmail(event.target.value)} placeholder="Email" required/>
                    <input type="password" name="pass" value={pass} onChange={(event)=>setPass(event.target.value)} placeholder="Password" required/>
                    <div className="div-button">
                        <button type="submit" className="btn" name="register">Register</button>
                    </div>
                </form>
            </div>
        </div>
            <h1>{output}</h1>
        </>
    )
}

export default RegisterForm;