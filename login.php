<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

session_regenerate_id();

require('../httpd.private/database_login_info.php');  
// Create connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);
// Throw error if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// define variables and set to empty values
$loginUsernameError = $loginPasswordError = $wrongLoginInfo = "";
$loginUsername = $loginPassword = $loginPasswordTested = "";
// Check that the request mode used in the form is post, as post is hiding senstive information, unlike GET.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['loginBackButton'])) {
        header('location: index.php');
        exit;
        
    }
  if (empty($_POST["loginUsername"])) {
    $loginUsernameError = "Userame is required";
  } else {
     $loginUsernameTested = securityCheck($_POST["loginUsername"]);
     $loginUsername = mysqli_real_escape_string($conn, $loginUsernameTested);
     $loginUsernameError = "";
  }
    
  if (empty($_POST["loginPassword"])) {
    $loginPasswordError = "Password is required";
  } else {  
     $loginPasswordTested = securityCheck($_POST["loginPassword"]);
     $loginPassword = mysqli_real_escape_string($conn, $loginPasswordTested);
     $loginPasswordError = "";
      
  }
    
}
function securityCheck($data) {
  $data = trim($data); // Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
  $data = stripslashes($data); // Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
  $data = htmlspecialchars($data);
  return $data;
}
// If the form is submitted
if (isset($_POST["loginUsername"]) and isset($_POST["loginPassword"])){
    // Checking the values are existing in the database or not
    $query = "SELECT * FROM `Users` WHERE username='$loginUsername'";
 
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    $user = mysqli_fetch_assoc($result);
    
    $count = mysqli_num_rows($result);
    
    $passwordCheck = password_verify($_POST["loginPassword"], $user['password']);
    // if nubmer of rows == 1 then the there exists a user with given username and password
    if ($count == 1 and $passwordCheck){
        $_SESSION['loginUsername'] = $loginUsername;
        $_SESSION['loggedIn'] = true;
    }
    else {
        $wrongLoginInfo = "Wrong username and/or password";
    }
}

if (isset($_SESSION['loginUsername'])){
    header('location: profile.php');
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
    
        <div id="login-header">Login</div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div id="input-column">
            <div id="name-row">
                <div id="name-text">Name:</div>
            
                <input id="username-input" type="text" name="loginUsername" value="<?php echo $loginUsername;?>">
       
            
       
            </div>
            <div id="password-row">
            
                <div id="password-text">Password:</div>
            
                <input id="password-input" type="password" name="loginPassword" value="<?php echo $loginPassword;?>">
                
            </div>
            
        </div>
            

        <div id="login-button-row">
            <input class="button" type="submit" name="submit" value="SUBMIT" id="submit-button">
    
            <button type="submit" name="loginBackButton" id="login-back-button" class="button">BACK</button>
        </div>
        </form>
    
    
    
    
    <br><br>
    <?php echo $loginUsernameError?>
    <br><br>
    <?php echo $loginPasswordError?>
    <br><br>
    <?php echo $wrongLoginInfo?>
    

        
    </div>
</div>
    
</body>
</html>