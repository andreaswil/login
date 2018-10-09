<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

session_regenerate_id();

// Chooses whic page to go to, based on button press

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['loginButton'])) {
        header('location: login.php');
        exit;
        
    }
        

    elseif (isset($_POST['registerButton'])) {
        header('location: register.php');
        exit;
        
        
    }

}

?>

<!DOCTYPE HTML>  
<html>
<head>

    <!-- Links for the different CSS files -->
    <link rel="stylesheet" type="text/css" href="css/index.css?version=52">
    <link href="https://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
 

    <!-- Meta info -->
    <meta charset="UTF-8">
    <meta name="description" content="Williams User System">
    <meta name="keywords" content="HTML,CSS,JavaScript, PHP">
    <meta name="author" content="Andreas Williams">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Williams User System</title>
</head>

<body>

<div id="index-card-box">
    
    <div id="index-card">

        <div id="index-header">Williams User System</div>
        <div id="index-header-underline"></div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div id="button-row">
            <button type="submit" name="loginButton" id="login-button" class="button">LOGIN</button>
            <button type="submit" name="registerButton" id="register-button" class="button">REGISTER</button>
        </div>
        </form>
    </div>
    
</div>
    
</body>
</html>