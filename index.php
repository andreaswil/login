    
<?php

require('../connect.php');

// Create connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

// Throw error if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

  
// Various checks for username and passwords
?>

<!DOCTYPE HTML>  
<html>
<body>  

<?php
// define variables and set to empty values
$loginUsernameError = $loginPasswordError = "";
$loginUsername = $loginPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["loginUsername"])) {
    $loginUsernameError = "Name is required";
  } else {
    $loginUsername = test_input($_POST["loginUsername"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$loginUsername)) {
      $loginUsernameError = "Only letters and white space allowed"; 
    }
  }
    
  if (empty($_POST["loginPassword"])) {
    $loginPasswordError = "Password is required";
  } else {  
     $loginPassword = test_input($_POST["loginPassword"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$loginPassword)) {
       $loginPasswordError = "Only letters and white space allowed"; 
     }
   }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Login</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="loginUsername" value="<?php echo $loginUsername;?>">
  <br><br>
  Password: <input type="text" name="loginPassword" value="<?php echo $loginPassword;?>">
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $loginUsername;
echo "<br><br>";
echo $loginPassword;
echo "<br><br>";
?>

</body>
</html>