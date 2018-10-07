<?php
//require('connect_to_database.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connect_to_database.php');
// define variables and set to empty values
$loginUsernameError = $loginPasswordError = "";
$loginUsername = $loginPassword = "";

echo "<script>console.log('faenihelvete'));</script>";
// Check that the request mode used in the form is post, as post is hiding senstive information, unlike GET.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enterButton'])) {
        if (empty($_POST["loginUsername"])) {
            $loginUsernameError = "Userame is required";
        }   
        else {
            $loginUsername = test_input($_POST["loginUsername"]);
            // check if name only contains letters and whitespace
            if (!preg_match("^[a-zA-Z0-9][a-zA-Z0-9_]{2,29}$^",$loginUsername)) {
            // A regexp for general username entry. Which doesn't allow special characters other than underscore. Username must be of length ranging(3-30). starting letter should be a number or a character.
                $loginUsernameError = "Only letters, numbers and underscores allowed"; 
        }
    }
    
    if (empty($_POST["loginPassword"])) {
        $loginPasswordError = "Password is required";
    }
        else {    
            $loginPassword = test_input($_POST["loginPassword"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$loginPassword)) {
                // Password must contain at least one letter, at least one number, and be longer than six charaters.
                $loginPasswordError = "Password must contain at least one letter, at least one number, and be longer than six charaters."; 
            }
        }
    }
}

function test_input($data) {
    $data = trim($data); // Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
    $data = stripslashes($data); // Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
    $data = htmlspecialchars($data);
    return $data;
}

//If someone filled out the log in form and clicked submit
if (isset($_POST["loginUsername"]) and isset($_POST["loginPassword"])){
    //Checking the values are existing in the database or not
    $query = "SELECT * FROM `Users` WHERE username='$loginUsername' and password='$loginPassword'";
 
    $result = mysqli_query($conn, $query) or die(mysqli_error($connection)); 
    $count = mysqli_num_rows($result);
    // if nubmer of rows == 1 then the there exists a user with given username and password
    if ($count == 1){
        $_SESSION['loginUsername'] = $loginUsername;
        $_SESSION['loggedIn'] = true;
    }
}
// If log in was succsessful, redirect them to their profile page
if (isset($_SESSION['loginUsername'])){
    include('profile.php');
    exit;
    
}

?>
