<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require('../database_login_info.php');
// Create connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);
// Throw error if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// define variables and set to empty values
$loginUsernameError = $loginPasswordError = $wrongLoginInfo = "";
$loginUsername = $loginPassword = $loginPasswordTested = "";
$loginUsernamePregCheck = $loginPasswordPregCheck = "";
// Check that the request mode used in the form is post, because post is hiding senstive information, unlike GET.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['registerBackButton'])) {
        header('location: index.php');
        exit;
        
    }
  if (empty($_POST["loginUsername"])) {
    $loginUsernameError = "Userame is required";
  } else {
     
     $loginUsernameTested = test_input($_POST["loginUsername"]);
     $loginUsername = mysqli_real_escape_string($conn, $loginUsernameTested);
     $loginUsernameError = "";
     $loginUsernamePregCheck = preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{5,20}$/', $loginUsername);
  
    
    if (!$loginUsernamePregCheck) {
      // one number, one uppercase letter, minimum 5 characters
      $loginUsernameError = "Username: one number, one uppercase letter, minimum 5 characters"; 
    }
      else {
        $loginUsernameError = "";
      }
  }
    
  if (empty($_POST["loginPassword"])) {
    $loginPasswordError = "Password is required";
  } else {  
     $loginPasswordTested = test_input($_POST["loginPassword"]);
     $loginPassword = mysqli_real_escape_string($conn, $loginPasswordTested);
     $loginPasswordError = "";
     $loginPasswordPregCheck = preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{5,20}$/', $loginPassword);
     $loginPassword = password_hash($loginPassword, PASSWORD_BCRYPT);
     
      
     if (!$loginPasswordPregCheck) {
       // one number, one uppercase letter, minimum 5 characters
       $loginPasswordError = "Password: one number, one uppercase letter, minimum 5 characters"; 
     }
   }
}

function test_input($data) {
  $data = trim($data); // Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
  $data = stripslashes($data); // Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
  $data = htmlspecialchars($data);
  return $data;
}
//If the form is submitted
if (isset($_POST["loginUsername"]) and isset($_POST["loginPassword"]) and $loginUsernamePregCheck and $loginPasswordPregCheck){
    $query = "SELECT * FROM `Users` WHERE username='$loginUsername' and password='$loginPassword'";
 
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
    $count = mysqli_num_rows($result);
    // if nubmer of rows == 1 then the there exists a user with given username and password
    if ($count == 1){
        $wrongLoginInfo = "Username already taken";
    }
    else{
        // Checking the values are existing in the database or not
        $query = "INSERT INTO Users (username, password)" . "VALUES ('$loginUsername','$loginPassword')";
 
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    
        $wrongLoginInfo = "Registration succsessful!";
    }
   
}

?>




<!DOCTYPE HTML>  
<html>
<body>  

<h2>Register</h2>
    
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="loginUsername" value="<?php echo $loginUsername;?>">
  <br><br>
  Password: <input type="password" name="loginPassword">
  <br><br>
  
  <input type="submit" name="submit" value="Submit">
    
  <button type="submit" name="registerBackButton">Back</button>
  <br><br>
    
    
  <br><br>
  <?php echo $loginUsernameError?>
  <br><br>
  <?php echo $loginPasswordError?>
  <br><br>
  <?php echo $wrongLoginInfo?>
    
 
</form>

    
    
    
</body>
</html>