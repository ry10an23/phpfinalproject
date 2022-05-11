<?php
    include('config.php');

    // PRICE CHANEG FUNCTION
     // PRICE CHANEG FUNCTION
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
    <link rel="stylesheet" type="text/css" href="style.css">
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
                    <li><a href="#">LOGOUT</a></li>
                </ul>
            </div>
            <div class="intro_text">
                <h1>Welcome to REJ Airline</h1>
                <h4 class="contents1">We are providing reservation system</h4>
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
            <li>
                <input class="button" type="submit">
            </li>
        </ul>
    </form>
    <script>
        function qurantine()
            {
                alert('Newyork will require qurantine. Please check your itinerary before you take the flight.');
            }
    </script>
    <?php

        $db_travel = new mysqli($DBServer,$username,$password,$dbName);
        if($db_travel->connect_error){
            echo $db_travel->connect_error;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if(isset($_POST['arrival'])){
                $arrival = $_POST['arrival'];
                $departure = $_POST['departure'];
                $date = $_POST['date'];
                $person = $_POST['person'];
                
            
                $selectQuery = "SELECT * FROM country_tb WHERE Country='$arrival'";
                $result = $db_travel->query($selectQuery);

                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                       //  echo var_dump($row['Stock']);
                        if ($person <= $row['Stock']) {
                            $finalPrice = $row['price'] * $person + priceDiscountPeople() * $person +  priceDiscountSeason() * $person;
                            echo 'From '.$departure.' To ' .$row['Country'].' Flight in '.$date.' ticket is available now </br>';
                            echo 'Price is : $'.$finalPrice;
                            // SaveIt(Notepad) button
                            echo "<br/><button onclick=".'SaveIt("'.$row['Country'].'","'.$date.'","'.$finalPrice.'","'.$person.'",)'."> Save It</button><br/>";
                            // Booking Button    
                            echo "<form action='' method='POST'>
                                   <input type='hidden' name='person' value=".$person.">
                                   <input type='hidden' name='destination' value=".$arrival.">
                                   <button name='countryId' value=".$row['id'].">Book Flight</button>
                                   </form>";

                        } else  
                        {
                            //   suggest other nearest country 
                            $selectQuery2 = "SELECT * FROM country_tb";
                            $result2 = $db_travel->query($selectQuery2);

                            if($result2->num_rows>0){
                                while($row2 = $result2->fetch_assoc()){
                                   if($row['continent'] === $row2['continent']){
                                       if($row['Country'] !== $row2['Country']){
                                           echo "I'm sorry, You can't book this arrival <br/>";
                                           echo "Another option is ".$row2['Country'];
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
                $countryId = $_POST['countryId'];
                $arrival = $_POST['destination'];
                $person = $_POST['person'];

                $book_ticketQuery = "UPDATE country_tb SET Stock = Stock - $person WHERE id = $countryId";
                $book = $db_travel->query($book_ticketQuery);

                echo "Your Flight to $arrival for $person person's booking sucessfully<br/>";
                
                //quratnine function
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
            + save_date + ' season, the price is : ' + save_price + '<br/>'
        );
    }    
</script>

</html>