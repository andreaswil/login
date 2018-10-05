<html>

<head>

    <!-- Links for the different CSS files -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <!-- Meta info -->
    <meta charset="UTF-8">
    <meta name="description" content="Login">
    <meta name="keywords" content="HTML,CSS,JavaScript,PHP">
    <meta name="author" content="Andreas Williams">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>

<body>
    
    <?php

    require('../connect.php');

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
    
    ?>
    
</body>

</html>