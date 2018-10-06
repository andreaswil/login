<?php

if ($_SESSION['loggedIn'] == false){
    header("location: index.php");
}   

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("location: index.php");
}
?>

<!DOCTYPE HTML>  
<html>
<body>  
<h2>Welcome to your profile <?php echo $_SESSION['loginUsername']?></h2>

<form method="post">
    <button name="logout">Log out</button>
</form>
    
</body>
</html> 