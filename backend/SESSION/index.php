<?php 
// session = SGB used to store information on a user
//    to be used across multiple pages.
//    A user is assigned a session-id
//    ex. login credentials.
    session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    this is the login page
    <a href="home.php">This go to home page</a>
</body>
</html>

<?php
    $_SESSION["username"] = "hamid";
    $_SESSION["password"] = "hamid";
    echo $_SESSION["username"] . "<br>";
    echo $_SESSION["password"] . "<br>";

?>