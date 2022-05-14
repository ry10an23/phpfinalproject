<?php
    session_start();
    include('config.php');

    // GO BACK TO LOGIN PAGE WITHOUT USERNAME
    if (isset($_SESSION['UserName'])){
        $loginUserName = $_SESSION['UserName'];
    } else {
        header('Location: ./login.php');
    }

     // PRICE CHANGE FUNCTION
     function specialChars($value) {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    $loginUserName = $_SESSION['UserName'];

    function priceDiscountPeople(){
        if($_POST['person'] >= 5 && $_POST['person'] <= 7){
          return -30;
        } elseif ($_POST['person'] >= 8 && $_POST['person'] <= 10){
          return -50;
        }
    }

    function priceDiscountSeason(){
        if ($_POST['date'] == 'Summer'){
        return +50;
      } elseif ($_POST['date'] == 'Winter'){
        return -50;
      }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css"href="./style/register.css">
    <link rel="stylesheet" href="./style/main.css">
    <title>MAIN PAGE</title>
</head>

<body>
    <div class="wrap">
        <div class="intro_bg">
            <div class="header">
                <ul class="nav">
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">CART</a></li>
                    <li><a href="#">CONTACT</a></li>
                    <li><a href="./logout.php">LOGOUT</a></li>
                    
                </ul>
            </div>
            <div class="intro_text">
                <h1><?php echo specialChars($loginUserName); ?>, Welcome to REJ Airline</h1>
                <h4 class="contents1">Unforgettable travel experiences with a positive impact</h4>
            </div>
        </div>
    </div>

    <!-- intro end-->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
        <ul class="reservation">
            <li>
                <h3>Departure</h3>
                <select name="departure">
                    <option value="Vancouver">Vancouver</option>
                </select>
            </li>
            <li>
                <h3>Arrival</h3>
                <select name="arrival">
                    <option value="Tokyo">Tokyo</option>
                    <option value="Seoul">Seoul</option>
                    <option value="Toronto">Toronto</option>
                    <option value="Newyork">Newyork</option>
                    <option value="Paris">Paris</option>
                    <option value="Madrid">Madrid</option>
                </select>
            </li>
            <li>
                <h3>Date</h3>
                <select name="date">
                    <option value="Spring">Spring</option>
                    <option value="Summer">Summer</option>
                    <option value="Autumn">Autumn</option>
                    <option value="Winter">Winter</option>
                </select>
            </li>
            <li>
                <h3>Person</h3>
                <select name="person">
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
            <li class="buttonContainer">
                <input value="Submit" class="button" type="submit">
            </li>
        </ul>
    </form>
    <script>
        // function qurantine
        function qurantine()
            {
                alert('Newyork will require qurantine. Please check your itinerary before you take the flight.');
            }
    </script>

    <?php
        //Connect with DATABASE
        $db_travel = new mysqli($DBServer,$username,$password,$dbName);
        if($db_travel->connect_error){
            echo $db_travel->connect_error;
        }


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //FIND bookingId
            $select_booking_Id = "SELECT * FROM users_tb WHERE UserName = '$loginUserName'";
            $bookingInfoId = $db_travel->query($select_booking_Id) or die($db_travel->mysql_error);

            $selected_bookID = $bookingInfoId->fetch_array(MYSQLI_ASSOC);
            $find_bookingId = $selected_bookID['bookingId'];

            // IF the user have booking info,
            if(isset($find_bookingId)){
                echo "You've already made a reservation.<br/>";
            }

            //FIND flight ticket
            if(isset($_POST['arrival'])){
                $arrival = $_POST['arrival'];
                $departure = $_POST['departure'];
                $date = $_POST['date'];
                $person = $_POST['person'];
            
                $selectQuery = "SELECT * FROM country_tb WHERE Country='$arrival'";
                $result = $db_travel->query($selectQuery);

                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                        if ($person <= $row['Stock']) {
                            $finalPrice = $row['price'] * $person + priceDiscountPeople() * $person +  priceDiscountSeason() * $person;
                            
                            //Show the result..
                            echo '<div class="container"><div class="showResult">
                            <h2>[ Reservation result 🎁 ]<h2>
                            <p class="showCountry"> From
                            <span class="departure"> '.$departure.' </span>To 
                            <span class="arrival"></br>'.$row['Country'].'</span> 
                            Flight</br> with '.$person. ' person</br> in '.$date.' 
                                ticket<p id="showPrice"> 
                            <span class="price">Price :<span class="numOfprice"> $'.$finalPrice.'💰</span></span>
                            </p></p></div></div>';
                            
                            // SaveIt(Notepad) button
                            echo "<br/><button class='saveBtn' onclick=".'SaveIt("'.$row['Country'].'","'.$date.'","'.$finalPrice.'","'.$person.'",)'."> Save It</button><br/>";
                            // Booking Button    
                            // Iwill need <input type='hidden' name='userId' value=".$userId.">
                            echo "<form action='' method='POST'>
                                   <input type='hidden' name='person' value=".$person.">
                                   <input type='hidden' name='destination' value=".$arrival.">
                                   <input type='hidden' name='date' value=".$date.">
                                   <input type='hidden' name='finalprice' value=".$finalPrice.">
                                   <button class='bookBtn' name='countryId' value=".$row['id'].">Book Flight</button>
                                   </form>";

                        } else  
                        {
                            //IF there is no ticket, suggest other nearest country 
                            $selectQuery2 = "SELECT * FROM country_tb";
                            $result2 = $db_travel->query($selectQuery2);

                            if($result2->num_rows>0){
                                while($row2 = $result2->fetch_assoc()){
                                   if($row['continent'] === $row2['continent']){
                                       if($row['Country'] !== $row2['Country']){
                                        echo '<div class="container"><div class="suggestion"><p class="message">Sorry❗️, You can not book this arrival</p> <br/> <h2 class="suggestionMessage">How about other Country ?</h2></br><p class="country">Another option is <span class="countryword">'.$row2['Country'].'</span></P></div>';
                                       }
                                   }
                                }
                            }
                        }
                    }
                }  
                else{
                    echo "no";
                }
            }
            // Booking function. 
            if(isset($_POST['countryId'])){
                $username = $loginUserName;;
                $countryId = $_POST['countryId'];
                $arrival = $_POST['destination'];
                $person = $_POST['person'];
                $date = $_POST['date'];
                $finalPrice2 = $_POST['finalprice'];

                //decrease stock of the ticket which is booked
                $decrease_ticketQuery = "UPDATE country_tb SET Stock = Stock - $person WHERE id = $countryId";
                $ticket = $db_travel->query($decrease_ticketQuery);

                //Insert booking infomation to bookinfInfo_tb
                $book_ticketQuery = "INSERT INTO bookingInfo_tb 
                (username,country, people_num, season, price)
                VALUES('$username', '$arrival', '$person', '$date','$finalPrice2')";
                $book = $db_travel->query($book_ticketQuery);

                echo "<h2>Your Flight to $arrival for $person person's booking sucessfully</h2><br/>";
                

                //Insert bookingId INTO user_tb Booking_info
                $selectId_query = "SELECT * FROM users_tb";
                $userID = $db_travel->query($selectId_query) or die($db_travel->mysql_error);


                // Find Book_ID
                $select_bookingId = "SELECT MAX(bookingId) AS bookID FROM bookingInfo_tb";
                $booking_ID = $db_travel->query($select_bookingId) or die($db_travel->mysql_error);
                $bookID = $booking_ID->fetch_array(MYSQLI_ASSOC);
                $Book_ID = $bookID['bookID'];

                //find userID
                $select_userId = "SELECT id FROM users_tb";
                $user_ID = $db_travel->query($select_userId) or die($db_travel->mysql_error);
                $userID = $user_ID->fetch_array(MYSQLI_ASSOC);
                $User_ID = $userID['id'];

                // Insert Book_ID INTO users_tb -> bookingId
                $insert_bookingId= "UPDATE users_tb SET bookingId = $Book_ID WHERE UserName = '$username'";
                $bookInfotoUser = $db_travel->query($insert_bookingId) or die($db_travel->mysql_error);


                //call quratnine function
                if($arrival == 'Newyork'){
                    echo '<script> qurantine(); </script>';
                }
            }
            
            $db_travel->close();
        }
    ?>
</body>
<script>
    // Show the result on another window.
    function SaveIt(save_country, save_date, save_price, save_person)
    {
        var myWindow = window.open("", "MsgWindow", "width=500,height=300");
        myWindow.document.write(
            'For ' + save_person +' Person, To ' + save_country +' in ' 
            + save_date + ' season, the price is : $' + save_price + '<br/>'
        );
    }    
</script>

</html>