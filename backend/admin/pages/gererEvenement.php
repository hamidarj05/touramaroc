<?php
include '../../../db/connectDB.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventName = $_POST['eventName'];
    $eventCity = $_POST['eventCity'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $eventDescription = $_POST['eventDescription'];
    $eventImages = $_FILES['eventImages'];
    $imagesUrls = [];
    for ($i = 0; $i < count($eventImages['name']); $i++) {
        if (!empty($eventImages['tmp_name'][$i])) {
            $tmpName = $eventImages['tmp_name'][$i];
            $fileName = $eventImages['name'][$i];
            $targetPath = 'uploads/' . $fileName; 
            move_uploaded_file($tmpName, $targetPath);
            $imagesUrls[] = $targetPath;
        }
    }
    if (isset($_GET["EditEvent"])) {
        $idEditEvent = $_GET["idEditEvent"];
        $stmt = $conn->prepare("UPDATE evenements SET nom = :nom, lieu = :ville_id,
                                                             description_evenement = :description ,
                                                             dateDebut = :datedebut, dateFin = :datefin
                                            WHERE id_evenement = :id");
        $stmt->execute([
            ':nom' => $eventName,
            ':ville_id' => $eventCity,
            ':description' => $eventDescription,
            ':datedebut' => $dateDebut,
            ':datefin' => $dateFin,
            ':id' => $idEditEvent
        ]);
        foreach ($imagesUrls as $imageUrl) {
            $stmt = $conn->prepare("DELETE FROM images_evenement WHERE id_evenement = :id");
            $stmt->execute([':id' => $idEditEvent]);
            $stmt = $conn->prepare("INSERT INTO images_evenement (id_evenement, urlSrc, alt) 
                                            VALUES (:evenement_id, :urlSrc , :altText)");
            $stmt->execute([
                ':evenement_id' => $idEditEvent,
                ':urlSrc' => $imageUrl,
                ':altText' => $eventName
            ]);
        }
        header("Location:../../../frontend/admin/dashboard.php?page=events&success=Evenement modifiée avec succès");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO evenements (nom, lieu, description_evenement, dateDebut,dateFin) 
                                            VALUES(:name, :city_id, :description, :dateDebut, :dateFin)");
        $stmt->execute([
            ':name' => $eventName,
            ':city_id' => $eventCity,
            ':description' => $eventDescription,
            ':dateDebut' => $dateDebut,
            ':dateFin' => $dateFin
        ]);
        $eventId = $conn->lastInsertId();
        foreach ($imagesUrls as $imageUrl) {
            $stmt = $conn->prepare("INSERT INTO images_evenement (id_evenement, urlSrc, alt) 
                                        VALUES (:evenement_id, :urlSrc , :altText)");
            $stmt->execute([
                ':evenement_id' => $eventId,
                ':urlSrc' => $imageUrl,
                ':altText' => $eventName
            ]);
        }
        header("Location:../../../frontend/admin/dashboard.php?page=events&success=Evenement ajouté avec succès");
        exit();
    }
}
