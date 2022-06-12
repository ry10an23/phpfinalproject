import React from 'react';
import {useState} from "react";
// import $ from "jquery"; 

const Booking = (props) => {

    const [arrival, setArrival] = useState("");
    const [person, setPerson] = useState("");

    return(
        <>
            <h2>Your Flight to {props.arrival} for {props.person} person's booking sucessfully</h2><br/>
        </>
    )
};

export default Booking;