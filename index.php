<html>

<head>

    <!-- Links for the different CSS files -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <!-- Meta info -->
    <meta charset="UTF-8">
    <meta name="description" content="Login">
    <meta name="keywords" content="HTML,CSS,JavaScript,PHP">
    <meta name="author" content="Andreas Williams">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>

<body>
    
    <?php

    require('../connect.php');

    // Create connection to MySQL database
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Throw error if connection failed
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // Various checks for username and passwords
    
    $usernameError = $passwordError = "";
    $username = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
        $nameError = "Name is required";
        }
        
        else {
        $username = securityCheck($_POST["username"]);
        
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $usernameError = "Only letters and white space allowed"; 
        }
        }
  
        if (empty($_POST["password"])) {
            $passwordError = "Password is required";
        } else {
            $password = securityCheck($_POST["password"]);
        }
        
    }
  
    function securityCheck($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    ?>
    
    <!-- Input form for logging in --> 
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
        // The htmlspecialchars prevents hacker exploits by converting special characters to HTML entities. Server is a super global variable that returns the filename of the currently executing script by passing PHP_SELF.
        ?>" method="post">
        
        Username: <input type="text" name="name" value="<?php echo $username; ?>">
        
        <?php 
        if empty($nameError == false) {
            echo $nameError;
            $nameError = "";
        }
        echo $nameErr; 
        ?>
        
        <br><br>
        
        Password: <input type="text" name="password" value="<?php echo $password;?>">
        
        <?php 
        if empty($passwordError == false) {
            echo $passwordError;
            $passwordError = "";
        }
        echo $passwordError;
        ?>
        
        <br><br>
        <input type="submit" name="submit" value="Submit"> 
    </form>
    
    <?php
        echo "<h2>Your Input:</h2>";
        echo $username;
        echo "<br>";
        echo $password;
        echo "<br>";
    ?>
    
</body>

</html>