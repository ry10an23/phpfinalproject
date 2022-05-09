<?php
    include('config.php');
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
            $db_travel = new mysqli('localhost', 'root', '' ,'travel_db');
            $insertQuery = $db_travel->prepare('SELECT id, Username, Password FROM users_tb WHERE Username=?');
            if(!$insertQuery){
                die($db_travel->error);
            }

            $insertQuery->bind_param('s', $uname);
            $success = $insertQuery->execute();
            if(!$success) {
                die($db_travel->error);
            }

            $insertQuery->bind_result($id, $username, $password);
            $insertQuery->fetch();

            var_dump($id, $username, $password);
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

</head>
<body>
    <h1>WELCOME TO OUR WEBSITE</h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="YOUR USERNAME" value="<?php echo specialChars($uname); ?>"><br/>
        <?php if(isset($error['login']) && $error['login'] === 'blank'): ?>
        <p style="color: red;">Please enter your username</p>
        <?php endif;?>
        <input type="password" name="password" placeholder="YOUR PASSWORD" value="<?php echo specialChars($password); ?>"><br/>
        <?php if(isset($error['login']) && $error['login'] === 'blank'): ?>
        <p style="color: red;">Please enter your password</p>
        <?php endif;?>
        <button type="submit" class="btn btn-success" name="login">LOGIN</button>
        <a href="register.php">Please register if you are not yet a membership</a>
    </form>


</body>
</html>