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
<body>  
<h2>Welcome to your profile <?php echo $_SESSION['loginUsername']?></h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    <button name="logout">Log out</button>
    <button type="submit" name="profileBackButton">Back to homepage</button>
</form>
    
</body>
</html> 