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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            margin:0;
            /* color: lightblue; */
            background:url(./img/login_img.jpg);
            background-size: 150%;
            background-repeat: no-repeat;
            background-position: center;
        }

        a {
            text-decoration: none;
        }
        h1 {
            border: 1px solid green;
        }
        form{
            border: 1px solid red;
        }

        .login-wrap{
        width: 100%;
        margin:auto;
        margin-top: 7%;
        max-width:510px;
        min-height:510px;
        position:relative;
        background-size: cover;
        background-color: rgba(255,255,255,0);
        background-blend-mode: lighten;
        box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
        }

        .login-form {
            border: 1px solid green;
            width:100%;
            height:100%;
            position:absolute;
            padding:90px 70px 50px 70px;
            background:rgba(0,0,0,0.1);  
        }

        .button{
            border: 1px solid blue;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-form">
            <h1>WELCOME TO OUR WEBSITE</h1>
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
                    <button type="submit" class="btn" name="login">LOGIN</button>
                    <button class="btn"><a href="register.php">Please register if you are not yet a membership</a></button> 
                </div>
            </form>
        </div>
    </div>


</body>
</html>