<?php
// 1.Mysql extension
// 2.PDO  (Php Data Object)

$db_server = "localhost";
$db_user = "root";
$db_password = "hamid";
$db_name = 'touramaroc';
$conn = "";

try{
    $conn = mysqli_connect($db_server,
                       $db_user,
                       $db_password,
                       $db_name);
}
catch(mysqli_sql_exception){
    echo "Could not connecte!<br>";
}

if($conn){
    echo "You are conected<br>";
}


?>