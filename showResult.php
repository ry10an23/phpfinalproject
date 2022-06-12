<?php
     function priceDiscountPeople(){
        if($person >= 5 && $person <= 7){
          return -30;
        } elseif ($person >= 8 && $person <= 10){
          return -50;
        }
    }

    function priceDiscountSeason(){
        if ( $date == 'Summer'){
        return +50;
      } elseif ( $date == 'Winter'){
        return -50;
      }
    }

?>

<?php
    require('./config.php');
    
    try{
        $opc = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        );
    
        $dsn = "mysql:host=".$DBServer.";dbname=".$dbName;
        $pdo = new PDO($dsn, $username, $password, $opc);
        
    } catch(PDOException $e){
        print_r('Error connection: '. $e->getMessage());
    }

     $departure = $_GET['departure'];
     $date = $_GET['date'];
     $person = $_GET['person'];
     $arrival = $_GET['arrival'];
    
try{
    $selectCommand = "SELECT * FROM country_tb WHERE Country='$arrival'";
    $result = $pdo->prepare($selectCommand);
    $result->execute();
}catch(PDOException $e){
    print_r('Error connection: '. $e->getMessage());
}


   
    if($result->rowCount()>0){
        while($row = $result->fetch()){
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
                $result2 = $pdo->query($selectQuery2);

                if($result2->rowCount()>0){
                    while($row2 = $result2->fetch()){
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
?>