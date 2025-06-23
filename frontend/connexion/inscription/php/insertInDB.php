<?php
session_start(); 

if (!empty($_SESSION)){
    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];
    $telephone = $_SESSION["telephone"];
    $pays = $_SESSION["pays"];
    $ville = $_SESSION["ville"];
    $adresse = $_SESSION["adresse"]; 
    // $email = $_SESSION["email"];
    $email = filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new Exception("Email invalide.");
        }

    $password = $_SESSION["password"];
    $confirmPassword = $_SESSION["confirmPassword"];
    $telephone = $_SESSION["telephone"]; 
    $dateActuiel = new DateTime(); 
    $date_creation = $dateActuiel->format("Y-m-d"); 
    
    // Sécurisation du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        require_once "connexionBD.php";
        $pdo = connexion("localhost", "touramaroc", "root", "simoo@365");

        if (!$pdo) {
            throw new Exception("Un problème s’est produit lors de la connexion à la base de données");
        }

        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, pays, ville, adresse, telephone,   email, mot_de_passe, confirmPwd ,  date_inscription )
        VALUES (:nom, :prenom, :pays, :ville, :adresse, :telephone,  :email, :mot_de_passe, :confirmPwd  , :date_inscription )");

        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":pays", $pays);
        $stmt->bindParam(":ville", $ville);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":telephone", $telephone); 
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mot_de_passe", $hashedPassword);
        $stmt->bindParam(":confirmPwd", $confirmPassword); 
        $stmt->bindParam(":date_inscription", $date_creation); 

        $stmt->execute();

      
        session_unset();
        session_destroy();
          $message = urlencode("votre compte creer avec succès.");
        header("Location: ../../index.php?message=". $message);
        exit();

    } catch(PDOException $e) {

        $message = urlencode($e->getMessage());
        header("Location: ../createAccountP3h.php?message=". $message);
        // echo "Erreur : " . $e->getMessage();
    }
}
?>
