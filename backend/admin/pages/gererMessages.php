<?php 
require_once '../../../db/connectDB.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $nom = $_POST['nom'] ;
    $email = $_POST['email'] ;
    $sujet = $_POST['sujet'] ;
    $message = $_POST['message'] ; 
    $stmt = $conn->prepare("
            INSERT INTO contact (nom, email, sujet, message)
            VALUES (:nom, :email, :sujet, :message)
        ");
        $stmt->execute([
            ':nom'     => $nom,
            ':email'   => $email,
            ':sujet'   => $sujet,
            ':message' => $message,
        ]);
        header("Location:../../../frontend/user/pages/contact/index.php?success=Message envoyer avec succès");

}  
?>
