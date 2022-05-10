<?php
    //include('./config.php');
    $DBServer = "localhost";
    $username = "root";
    $password = "";
    $dbName = "testHR_db";
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
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="FirstName" placeholder="Write Firstname"/><br/>
        <input type="text" name="LastName" placeholder="Write Lastname"/><br/>
        <p>Choose Department</p>
        <select name="Department">
            <option value="frontdev">FrontEnd</option>
            <option value="backdev">BackEnd</option>
            <option value="testengineer">TestEngineer</option>
            <option value="native">Native</option>
            <option value="design">Design</option>
        </select><br/><br/>
        <input type="text" name="Position" placeholder="Write Position"/><br/>
        <input type="number" name="Salary" placeholder="Write Salary"/><br/>
        <p>choose the Hired Date</p>
        <input type="date" name="HireDate" placeholder="chooes the date"/><br/>
        <button type="submit">Register</button>
    </form>
    <?php
        $dbCon = new mysqli($DBServer, $username, $password, $dbName);
        if($dbCon->connect_error){
            die("Connection Failed:".$dbCon->connect_error);
        }

        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            // IF there is FirstName, execute this branch (register the userinfo)
            if (isset($_POST['FirstName'])) {
                $fName = $_POST['FirstName'];
                $lName = $_POST['LastName'];
                $DP = $_POST['Department'];
                $position = $_POST['Position'];
                $salary = $_POST['Salary'];
                $hiredate = $_POST['HireDate'];

                $insertQuery = "INSERT INTO employers_tb
                (FirstName, LastName, Department, Position, Salary, HireDate)
                VALUES ('$fName', '$lName','$DP','$position', '$salary','$hiredate')";

                if($dbCon->query($insertQuery)===true){
                    echo "<h2> New Employer registered Successfully </h2>";
                }else{
                    echo "Error:".$dbCon->error;
                }
            }

            // IF there is empID, exucute this branch ( decrease salary)
            if(isset($_POST['empID'])) {
                $employeeId = $_POST['empID'];
                $book_ticketQuery = "UPDATE employers_tb SET Salary = Salary-1 WHERE employeeID = $employeeId";
                $book = $dbCon->query($book_ticketQuery);
            }
            
        }
        
        // Whether there is POST, execute this branch. ( show the result and buttons(save it, book flight))

        $selectQuery = "SELECT * FROM employers_tb";
        $result = $dbCon->query($selectQuery);


        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                // fetch_assoc() 결과를 배열로 저장
                echo "FirstName :".$row['FirstName']." LastName: ".$row['LastName']."<br/>Department:"
                .$row['Department']."<br/>Salary:".$row['Salary'];
                // [Save It] -> Show the result another window
                echo "<button onclick=".'SaveIt("'.$row['FirstName'].'","'.$row['LastName'].'")'."> Save It</button><br/>";
                // [Book Flight] -> Give the value(empID) to isset($_POST['empID'] and decrease the salary )
                echo "<form action='' method='POST'>
                        <button name='empID' value=".$row['employeeID'].">Book Flight</button>
                    </form>";
            }
        }
            
        $dbCon->close();
    ?>
</body>
    <script>

        // Show the result another window.
        function SaveIt(val, val2)
        {
            var myWindow = window.open("", "MsgWindow", "width=300,height=300");
            myWindow.document.write(
                '<table><tr>' + val + '</tr>'
            );
            myWindow.document.write(
                '<tr>' + val2+ '</tr></table>'
            );
        }
    </script>
</html>