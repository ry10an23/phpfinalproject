<?php
    include('config.php');
?>

<?php
    $form = [
        'fname' => '',
        'lname' => '',
        'uname' => '',
        'email' => '',
        'pass' => ''
    ];
    $error = [];

    // FUNCTION
    function specialChars($value) {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    // TO CHECK THE CONTENTS INSEDE FORM //
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $form['fname'] = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
        if($form['fname'] === ''){
            $error['fname'] = 'blank';
        }
        $form['lname'] = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS);
        if($form['lname'] === ''){
            $error['lname'] = 'blank';
        }
        $form['uname'] = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_SPECIAL_CHARS);
        if($form['uname'] === ''){
            $error['uname'] = 'blank';
        }
        $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        if($form['email'] === ''){
            $error['email'] = 'blank';
        }
        $form['pass'] = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
        if($form['pass'] === ''){
            $error['pass'] = 'blank';
        } else if (strlen($form['pass']) < 8) {
            $error['pass'] = 'length';
        }
    }
?>

<!-- Registration Form -->
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $db_travel = new mysqli('localhost', 'root', '' ,'travel_db');
        if($db_travel->connect_error){
            echo $db_travel->connect_error;
        }
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $password = $_POST['pass'];

        $insertQuery = "INSERT INTO users_tb(FirstName, LastName, UserName, Email, Password) VALUES('$fname', '$lname', '$uname', '$email', '$password')";

        if($db_travel->query($insertQuery) === true){
            echo "<h2>Your information was registered successfully</h2>";
        } else{
            echo "<h2>Something went wrong....</h2>".$db_travel->error;
        }
        $db_travel->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        First Name <span style="color: red;">* </span><input type="text" name="fname" placeholder="First Name"  value="<?php echo specialChars($form['fname']); ?>"><br/>
            <?php if(isset($error['fname']) && $error['fname'] ==='blank'): ?>
                <p style="color: red;">Please enter your First Name</p>
            <?php endif; ?>
        Last Name <span style="color: red;">* </span><input type="text" name="lname" placeholder="Last Name"  value="<?php echo specialChars($form['lname']); ?>"><br/>
            <?php if(isset($error['lname']) && $error['lname'] ==='blank'): ?>
                <p style="color: red;">Please enter your Last Name</p>
            <?php endif; ?>
        User Name <span style="color: red;">* </span><input type="text" name="uname" placeholder="User Name"  value="<?php echo specialChars($form['uname']); ?>"><br/>
            <?php if(isset($error['uname']) && $error['uname'] ==='blank'): ?>
                <p style="color: red;">Please enter your User Name</p>
            <?php endif; ?>
        Email Address <span style="color: red;">* </span><input type="email" name="email" placeholder="Email Address"  value="<?php echo specialChars($form['email']); ?>"><br/>
            <?php if(isset($error['email']) && $error['email'] ==='blank'): ?>
                <p style="color: red;">Please enter your Email Address</p>
            <?php endif; ?>
        Password <span style="color: red;">* </span><input type="password" name="pass" placeholder="Password" minlength="8" maxlength="20" value="<?php echo specialChars($form['pass']); ?>"><br/>
            <?php if(isset($error['pass']) && $error['pass'] ==='blank'): ?>
                <p style="color: red;">Please enter your Password</p>
            <?php endif; ?>
            <?php if(isset($error['pass']) && $error['pass'] ==='length'): ?>
                <p style="color: red;">Password should be more than 8 characters</p>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
    </form>
</body>
</html>                      