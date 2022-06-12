import {useState} from "react";
import $ from "jquery"; 

function DisplayReservation() {
    const [arrival, setArrival] = useState("");
    // const [season, setSeason] = useState("");
    // const [person, setPerson] = useState("");
    const [output, setOutput] = useState("");

    $.ajax({
        type: "POST",
        url: "http://localhost/phpfinalproject-main-5/loadArrivals.php", 
        success: function(data){
            setArrival(data);  
        }
    });

    

    const showStockInfo = () => {
        let arrivalSelected = $("#arrival option:selected").val();
        let personSelected =  $("#person option:selected").val();
        let dateSelected =  $("#date option:selected").val();
        // setArrival(arrivalSelected);
        // setPerson(personSelected);
        // setSeason(dateSelected);

        $.ajax({
            type: "GET",
            url: "http://localhost/phpfinalproject-main-5/showResult.php?arrival="+arrivalSelected+"&season="+dateSelected+"&person="+personSelected,
            success: function(data){
                setOutput(data);
            }
        });
    }

    return(
        <>
        {/* show options */}
         <ul className="reservation">
            <li>
                <h3>Departure</h3>
                <select name="departure">
                    <option value="Vancouver">Vancouver</option>
                </select>
            </li>
            <li>
                <h3>Arrival</h3>
                <select id="arrival" name='arrival' dangerouslySetInnerHTML={{__html: arrival}}>
                    
                </select>
            </li>
            <li>
                <h3>Date</h3>
                <select id="date" name="date">
                    <option value="Spring">Spring</option>
                    <option value="Summer">Summer</option>
                    <option value="Autumn">Autumn</option>
                    <option value="Winter">Winter</option>
                </select>
            </li>
            <li>
                <h3>Person</h3>
                <select id="person" name="person" >
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                </select>
            </li>
            <li className="buttonContainer">
                <input onClick={()=>showStockInfo()} 
                       value="Submit" 
                       className="button" 
                       type="submit"/>
            </li>
        </ul>

            {/* show result page */}
            <div dangerouslySetInnerHTML={{__html: output}}></div>
        </>
    )
}
export default DisplayReservation;
