<?php
    include('config.php');
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
    <form method="POST" action="<?php
    echo $_SERVER['PHP_SELF']?>">
        <ul class="reservation">
            <li>
                <h3>Departure</h3>
                <select name="departure">
                    <option value="vancouver">Vancouver</option>
                </select>
            </li>
            <li>
                <h3>Arrival</h3>
                <select name="arrival">
                    <option value="Japan">Japan</option>
                    <option value="Korea">Korea</option>
                    <option value="Canada">Canada</option>
                    <option value="US">US</option>
                    <option value="Spain">Spain</option>
                    <option value="Frence">Frence</option>
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
                <input type="number" name="person">
            </li>
        </ul>
        <input type="submit">
    </form>

    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $db_travel = new mysqli($DBServer,$username,$password,$dbName);
            if($db_travel->connect_error){
                echo $db_travel->connect_error;
            }

            $arrival = $_POST['arrival'];
            $date = $_POST['date'];
            $person = $_POST['person'];
        

            $selectQuery = "SELECT * FROM country_tb WHERE country='$arrival'" ;
            
            

            $result = $db_travel->query($selectQuery);
            
            
             if($result->num_rows>0){
                 while($row = $result->fetch_assoc()){
                    //  echo var_dump($row['Stock']);
                     if ($person <= $row['Stock']) {
                         echo 'Stock availabe: '. $row['Stock'];

                     } else {
                         echo 'No available';
                     }
                 }
             }else{
               
             }
            $dbcon->close();
            
            

        }

    ?>

</body>

</html>