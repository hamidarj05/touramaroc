<?php
session_start();
require_once "connexionBD.php";
require_once "User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["email"] ?? '');

    try {
        // $regex = "/^[^@\s]+@[^@\s]+\.[^@\s]+$/";

        // if (!preg_match($regex, $email)) {
        //     throw new Exception("L'email est invalide");
        // }
        $user = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", $email, "password123", "password123");
        $result = $user->valideEmail();

        if ($result !== true) {
            throw new Exception($result);
        }

        $pdo = connexion("localhost", "touramaroc", "root", "simoo@365");

         // Vérification de la connexion à la base de données
         if (!$pdo) {
            throw new Exception("Un problème s’est produit lors de la connexion à la base de données");
        }
   

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) {
            throw new Exception("Cet email n'a pas de compte");
        }
        $_SESSION["ForgotEmail"] = $email ;
            header("location:../modifyPassword.php");
    }catch (Exception $e) {
        header('location:../ForgotEmail.php?message='. urlencode($e->getMessage()));
    }}

?>