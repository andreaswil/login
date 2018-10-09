<?php

session_start();

if ($_SESSION['loggedIn'] == false){
    header("location: index.php");
}   
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("location: index.php");
}

 if (isset($_POST['profileBackButton'])) {
        header('location: index.php');
        exit;
        
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



    
<!-- The $_SERVER["PHP_SELF"] is a super global variable that returns the filename of the currently executing script. The htmlspecialchars() function converts special characters to HTML entities. This means that it will replace HTML characters like < and > with &lt; and &gt;. This prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms. -->

<div id="index-card-box">
    
    <div id="login-card">
    
        <div id="login-header">Profile</div>
        
        <div id="greeting">Welcome to your profile, <?php echo $_SESSION['loginUsername']?></div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div id="register-button-row">
            <button id="log-out-button" name="logout" class="button">LOG OUT</button>
            <button id ="home-button" type="submit" name="profileBackButton" class="button">HOME</button>
        </div>
        </form>
    
    
    
    
    

        
    </div>
</div>
    
</body>
</html>



