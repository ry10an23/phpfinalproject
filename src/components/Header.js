import React from 'react';
import {useState} from "react";
import $ from "jquery"; 

const Header = (props) => {
    const [username, setUsername] = useState("");

    return(
        <div className="wrap">
        <div className="intro_bg">
            <div className="header">
                <ul className="nav">
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">CART</a></li>
                    <li><a href="#">CONTACT</a></li>
                    <li><a href="./logout.php">LOGOUT</a></li>
                    
                </ul>
            </div>
            <div className="intro_text">
                <h1>{props.username}, Welcome to REJ Airline</h1>
                <h4 className="contents1">Unforgettable travel experiences with a positive impact</h4>
            </div>
        </div>
    </div>
    )
};

export default Header;