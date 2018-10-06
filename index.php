<?php
session_start();

require('../connect.php');


// Create connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

// Throw error if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sql query for creating users table
$createUsersSQLQuery = "CREATE TABLE Users (
userid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
)";


// Function for passing a query to the database
mysqli_query($conn, $createUsersSQLQuery);

// define variables and set to empty values
$loginUsernameError = $loginPasswordError = "";
$loginUsername = $loginPassword = "";

// Check that the request mode used in the form is post, as post is hiding senstive information, unlike GET.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["loginUsername"])) {
    $loginUsernameError = "Userame is required";
  } else {
    $loginUsername = test_input($_POST["loginUsername"]);
    // check if name only contains letters and whitespace
    if (!preg_match("^[a-zA-Z0-9][a-zA-Z0-9_]{2,29}$",$loginUsername)) {
      // A regexp for general username entry. Which doesn't allow special characters other than underscore. Username must be of length ranging(3-30). starting letter should be a number or a character.
      $loginUsernameError = "Only letters, numbers and underscores allowed"; 
    }
  }
    
  if (empty($_POST["loginPassword"])) {
    $loginPasswordError = "Password is required";
  } else {  
     $loginPassword = test_input($_POST["loginPassword"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$loginPassword)) {
        // Password must contain at least one letter, at least one number, and be longer than six charaters.
       $loginPasswordError = "Password must contain at least one letter, at least one number, and be longer than six charaters."; 
     }
   }
}

function test_input($data) {
  $data = trim($data); // Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
  $data = stripslashes($data); // Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
  $data = htmlspecialchars($data);
  return $data;
}

//3.1 If the form is submitted
if (isset($_POST["loginUsername"]) and isset($_POST["loginPassword"])){
    //3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `Users` WHERE username='$loginUsername' and password='$loginPassword'";
 
    $result = mysqli_query($conn, $query) or die(mysqli_error($connection)); 
    $count = mysqli_num_rows($result);
    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        echo '<script>console.log("Your stuff here")</script>';
        $_SESSION['loginUsername'] = $loginUsername;
    }else{
        //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        $fmsg = "Invalid Login Credentials.";
    }
}

if (isset($_SESSION['loginUsername'])){
    require ('user.php');
    exit;
}

session_unset();
session_destroy();


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
    
  <br><br>
    
 
</form>
    
</body>
</html>