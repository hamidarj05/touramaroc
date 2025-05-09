<?php 
// session = SGB used to store information on a user
//    to be used across multiple pages.
//    A user is assigned a session-id
//    ex. login credentials.
    session_start()
?>
<?php

    echo $_SESSION["username"] . "<br>";
    echo $_SESSION["password"] . "<br>";

?>