<?php
    include('config.php');
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
    <form action="main.php" method="POST">
        <input type="text" name="uname" placeholder="YOUR USERNAME"><br/>
        <input type="password" name="password" placeholder="YOUR PASSWORD"><br/>
        <button type="submit" class="btn btn-success">LOGIN</button>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Become our membership
        </button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Enter your information</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    First Name: <input type="text" name="fname" placeholder="First Name" required><br/>
                    Last Name: <input type="text" name="lname" placeholder="Last Name" required><br/>
                    User Name: <input type="text" name="uname" placeholder="User Name" required><br/>
                    Email Address: <input type="email" name="email" placeholder="Email Address" required><br/>
                    Password: <input type="password" name="password" placeholder="Password" required><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>

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
            $password = $_POST['password'];
    
            $insertQuery = "INSERT INTO users_tb(FirstName, LastName, UserName, Email, Password) VALUES('$fname', '$lname', '$uname', '$email', '$password')";
    
            if($db_travel->query($insertQuery) === true){
                echo "<h2>Your information was registered successfully</h2>";
            } else{
                echo "<h2>Something went wrong....</h2>".$db_travel->error;
            }
            $db_travel->close();
        }

    ?>
</body>
</html>