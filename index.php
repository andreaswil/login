<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['loginButton'])) {
        header('location: login.php');
        exit;
        
    }
        

    elseif (isset($_POST['registerButton'])) {
        require('register.php');
        
        
    }

}

?>

<!DOCTYPE HTML>  
<html>
<body>  


<h2>Welcome</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">    
    <button type="submit" name="loginButton">Login</button>
    <br><br>
    <button type="submit" name="registerButton">Register</button>
    <br><br>
 
</form>
    
</body>
</html>