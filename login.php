<?php
    session_start();

    //SHOW THE ERROR MESSAGE
    $error = [];
    $uname = "";
    $password = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        $uname = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        if($uname === "" || $password === ""){
            $error['login'] = "blank";
        } else {
            //LOGIN CHECK
            // $db_travel = new mysqli('localhost', 'root', '' ,'travel_db');
            // if($db_travel->connect_error){
            //     die("Connection failed:".$dbCon->connect_error);
            // }

            // $insertQuery = "SELECT * FROM users_tb WHERE Username='$uname', Password='$password'";
            // if($db_travel->query($insertQuery)===true){
            //     echo "<h2>Password is correct";
            // }else{
            //     echo "<h2>Password is NOT correct";
            // }
            // $db_travel->close();
            // $result = $db_travel->query($selectQuery);

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
            $selectQuery->fetch();

            var_dump($password, $hash); //SHOW THE RESLUT OF HASHED PASS AND USER TYPED PASSWORD

            if(password_verify($password, $hash)){ //COMPARE BETWEEN THE HASHED PASS AND PLAINTEXT PASSWORD ARE SAME OR NOT
                $_SESSION['UserName'] = $uname;
                header('Location: ./main.php');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PAGE</title>

    <link rel="stylesheet" href="./style/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    
</head>
<body>
    <div class="login-wrap">
        <div class="login-form">
            <h3>WELCOME TO OUR WEBSITE</h3>
            <form action="" method="POST">
                <label for="username">USERNAME</label>
                <input type="text" name="username" placeholder="YOUR USERNAME" value="<?php echo specialChars($uname); ?>"><br/>
                    <?php if(isset($error['login']) && $error['login'] === 'blank'): ?>
                    <p style="color: red;">Please enter your username</p>
                    <?php endif;?>

                <label for="username">PASSWORD</label>
                <input type="password" name="password" placeholder="YOUR PASSWORD" value="<?php echo specialChars($password); ?>"><br/>
                    <?php if(isset($error['login']) && $error['login'] === 'blank'): ?>
                    <p  class="error" style="color: red;">Please enter your password</p>
                    <?php endif;?>
                    
                    <?php if(isset($error['login']) && $error['login'] === 'failed'): ?>
                    <p class="error" style="color: red;">It's wrong password. Please try it again</p>
                    <?php endif;?>
                <div class="button">
                    <button type="submit" class="btn btn-login" name="login">LOGIN</button>
                    <button class="btn btn-newAccount"><a href="register.php">Create an Account</a></button> 
                </div>
            </form>
        </div>
    </div>


</body>
</html>