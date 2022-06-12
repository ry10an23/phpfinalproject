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

 try {
     $query = $pdo->prepare("SELECT * FROM country_tb");
     $query->execute();
     $output = "";
    if($query->rowCount() > 0){
        while($row = $query->fetch()){
                     $output .= "<option value='".$row['Country']."'>".$row['Country']."</option>";
                 }
         echo $output;
     } else {
         return NULL;
     }
 } catch(PDOException $e){
     echo $e->getMessage();
     return NULL;
 }
    
//    $sqlCon = new mysqli($servername,$username,$password,$dbname);
//     if($sqlCon->connect_error){
//         exit('DB Error');
//     }
//     var_dump($sqlCon->mysqli_connect_errno());
//     $selectCommand = "SELECT Country FROM country_tb";
//     $result = $sqlCon->query($selectCommand);
//     $output = "";
    
//     while($row = $result->fetch_assoc()){
//         $output .= "<option value='".$row['Country']."'>".$row['Country']."</option>";
//     }
//     $sqlCon->close();

//     echo $output;
?>