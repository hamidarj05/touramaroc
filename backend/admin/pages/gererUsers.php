<?php
require_once '../../../db/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $user_role = $_POST['user_role'];

    if (isset($_GET["EditUser"])) {
        $idEditUser = $_GET['id'];
        if (!empty($_POST['mot_de_passe'])) {
            $stmt = $conn->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe,
                                    telephone = :telephone, pays = :pays, ville = :ville, adresse = :adresse, user_role = :user_role
                                    WHERE id_user = :id");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe,
                ':telephone' => $telephone,
                ':pays' => $pays,
                ':ville' => $ville,
                ':adresse' => $adresse,
                ':user_role' => $user_role,
                ':id' => $idEditUser
            ]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email,
                                    telephone = :telephone, pays = :pays, ville = :ville, adresse = :adresse, user_role = :user_role
                                    WHERE id_user = :id");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':telephone' => $telephone,
                ':pays' => $pays,
                ':ville' => $ville,
                ':adresse' => $adresse,
                ':user_role' => $user_role,
                ':id' => $idEditUser
            ]);
        }

        header("Location:../../../frontend/admin/dashboard.php?page=users&success=Utilisateur modifié avec succès");
        exit();
    } else if (isset($_GET["AddUser"])) {
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, telephone, pays, ville, adresse, user_role) 
                                VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :pays, :ville, :adresse, :user_role)");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe,
            ':telephone' => $telephone,
            ':pays' => $pays,
            ':ville' => $ville,
            ':adresse' => $adresse,
            ':user_role' => $user_role
        ]);

        header("Location:../../../frontend/admin/dashboard.php?page=users&success=Utilisateur ajouté avec succès");
        exit();
    }
}
