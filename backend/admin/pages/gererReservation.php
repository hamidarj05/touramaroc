<?php
include '../../../db/connectDB.php';
 
if (isset($_GET['addReservation'])) {
    $stmt = $conn->prepare("INSERT INTO reservations (reserv_type, date_debut, date_fin, statut, user_id)
                            VALUES (:type, :debut, :fin, :statut, :user)");
    $stmt->execute([
        ':type' => $_POST['reservType'],
        ':debut' => $_POST['dateDebut'],
        ':fin' => $_POST['dateFin'],
        ':statut' => $_POST['statut'],
        ':user' => $_POST['userId']
    ]);

    header("Location:../../../frontend/user/pages/accueil/index.php?success=Réservation ajoutée avec succès");
    exit();
}
 
if (isset($_GET['editReservation']) && isset($_GET['idEditReservation']) && isset($_POST['updateReservation'])) {
    $id = $_GET['idEditReservation'];
    $stmt = $conn->prepare("UPDATE reservations 
                            SET reserv_type = :type, date_debut = :debut, date_fin = :fin, statut = :statut, user_id = :user 
                            WHERE id_reservation = :id");
    $stmt->execute([
        ':type' => $_POST['reservType'],
        ':debut' => $_POST['dateDebut'],
        ':fin' => $_POST['dateFin'],
        ':statut' => $_POST['statut'],
        ':user' => $_POST['userId'],
        ':id' => $id
    ]);

    header("Location: ../../../frontend/admin/dashboard.php?page=reservations&success=Réservation modifiée avec succès");
    exit();
}
 
if ($_GET['form'] == 'deleteReservation' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id_reservation = ?");
    $stmt->execute([$id]);

    header("Location: ../../../frontend/admin/dashboard.php?page=reservations&success=Réservation supprimée avec succès");
    exit();
}
