<?php
    session_start();
    include "./config.php";

    //SHOW THE ERROR MESSAGE
    $error = [];
    // $uname =  filter_input(INPUT_POST, '');
    // $password =  filter_input(INPUT_POST, '');
    $uname = $_POST['username'];
    $password = $_POST['password'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        $uname = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        if($uname === "" || $password === ""){
            $error['login'] = "blank";
        } else {
            
            // CONNECT TO THE DATABASE
            $db_travel = new mysqli('localhost', 'root', '' ,'travel_db');
            $selectQuery = $db_travel->prepare('SELECT UserName, Password FROM users_tb WHERE UserName=?');
            if(!$selectQuery){
                die($db_travel->error); //KILL THE EXUCUTION
            }

            $selectQuery->bind_param('s', $uname); //DEFINE THE USERNAME's DATA TYPE
            $success = $selectQuery->execute();
            if(!$success) {
                die($db_travel->error);
            }

            $selectQuery->bind_result($username, $hash);
            // echo $selectQuery;
            $selectQuery->fetch();

            // var_dump($selectQuery); //SHOW THE RESLUT OF HASHED PASS AND USER TYPED PASSWORD

            if(password_verify($password, $hash)){ //COMPARE BETWEEN THE HASHED PASS AND PLAINTEXT PASSWORD ARE SAME OR NOT
                $_SESSION['UserName'] = $uname;
                header('Location: http://localhost/php_finalproject/main.php');
                exit();
            } else {
                $error['login'] = 'failed';
            }
            $db_travel->close();
        }
        
    }

    function specialChars($value) {
        return htmlspecialchars($value, ENT_QUOTES);
    }
?>