import {useState} from "react";
import $ from "jquery"; 

function BookFlight() {
    const [arrival, setArrival] = useState("");
    const [person, setPerson] = useState("");

    $.ajax({
        type: "POST",
        url: "http://localhost/phpfinalproject-main-5/bookFlight.php", 
        success: function(data){
            setArrival(data);
            setPerson(data);
        }
    });
    
    return(
        <>
            <h2>Your Flight to {arrival} for {person} person's booking sucessfully</h2><br/>
        </>
    )
}
export default BookFlight;
