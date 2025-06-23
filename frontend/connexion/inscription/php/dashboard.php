<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashbord</title>
</head>
<body>
<?php
session_start();
echo "hello";

if (isset($_SESSION) && sizeof($_SESSION) !== 0): ?>
    <button>
        <a href="logout.php" onclick="return confirm('Etes-vous sûr de vouloir vous déconnecter')">logout</a>
    </button>
<?php
    echo "hello";
    print_r($_SESSION);
endif;
?>


</body>
</html>

