<?php
    session_start();

    // Supprimer toutes les variables de session
    $_SESSION = [];

    // Détruire la session
    session_unset();
    session_destroy();

    header("Location:dashboard.php");
exit();
?>
