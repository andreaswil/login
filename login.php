<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

require('database_login_info.php');
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
     $loginUsernameTested = test_input($_POST["loginUsername"]);
     $loginUsername = mysqli_real_escape_string($conn, $loginUsernameTested);
     $loginUsernameError = "";
  }
    
  if (empty($_POST["loginPassword"])) {
    $loginPasswordError = "Password is required";
  } else {  
     $loginPasswordTested = test_input($_POST["loginPassword"]);
     $loginPassword = mysqli_real_escape_string($conn, $loginPasswordTested);
     $loginPasswordError = "";
      
  }
    
}
function test_input($data) {
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
<body>  


<h2>Login</h2>
    
<!-- The $_SERVER["PHP_SELF"] is a super global variable that returns the filename of the currently executing script. The htmlspecialchars() function converts special characters to HTML entities. This means that it will replace HTML characters like < and > with &lt; and &gt;. This prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms. -->

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Name: <input type="text" name="loginUsername" value="<?php echo $loginUsername;?>">
    <br><br>
    Password: <input type="password" name="loginPassword" value="<?php echo $loginPassword;?>">
    <br><br>
  
    <input type="submit" name="submit" value="Submit">
    
    <button type="submit" name="loginBackButton">Back</button>
    
    <br><br>
    <?php echo $loginUsernameError?>
    <br><br>
    <?php echo $loginPasswordError?>
    <br><br>
    <?php echo $wrongLoginInfo?>
    
</form>
    
</body>
</html>