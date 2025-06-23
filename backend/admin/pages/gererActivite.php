<?php
include '../../../db/connectDB.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $activitieName = $_POST['activitieName'];
            $activitieCity = $_POST['activitieCity'];
            $activitiePrice = $_POST['activitiePrice'];
            $dateDebut = $_POST['dateDebut'];
            $dateFin = $_POST['dateFin'];
            $activitieDescription = $_POST['activitieDescription'];
            $activitieImages = $_FILES['activitieImages']; 
            $imagesUrls = [];
            for ($i = 0; $i < count($activitieImages['name']); $i++) {
                if (!empty($activitieImages['tmp_name'][$i])) {
                    $tmpName = $activitieImages['tmp_name'][$i];
                    $fileName = $activitieImages['name'][$i];
                    move_uploaded_file($tmpName, 'uploads/' . $fileName);
                    $imagesUrls[] = $fileName;  
                }
            }
            if (isset($_GET["EditActivitie"])){
                $idEditActivitie = $_GET['idEditActivitie'];
                $stmt = $conn->prepare("UPDATE activites SET titre = :titre, ville_id = :ville_id, prix = :price, dateDebut = :datedebut, dateFin = :datefin, activite_description = :description 
                                            WHERE activite_id = :id");
                $stmt->execute([
                    ':titre' => $activitieName,
                    ':ville_id' => $activitieCity,
                    ':price' => $activitiePrice,
                    ':datedebut' => $dateDebut,
                    ':datefin' => $dateFin,
                    ':description' => $activitieDescription,
                    ':id' => $idEditActivitie
                ]);
                foreach ($imagesUrls as $imageUrl) {
                    $stmt = $conn->prepare("DELETE FROM images_activites WHERE activite_id = :id");
                    $stmt->execute([':id' => $idEditActivitie]);
                    $stmt = $conn->prepare("INSERT INTO images_activites (activite_id, urlSrc, altText) VALUES (:activite_id, :urlSrc , :altText)");
                    $stmt->execute([
                        ':activite_id' => $idEditActivitie,
                        ':urlSrc' => $imageUrl,
                        ':altText' => $activitieName
                    ]);
                }
                header("Location:../../../frontend/admin/dashboard.php?page=activiteis&success=Activité modifiée avec succès");
                exit();
            }else{
                $stmt = $conn->prepare("INSERT INTO activites (titre, ville_id, prix, dateDebut, dateFin,  activite_description) 
                                            VALUES (:titre, :ville_id, :price, :datedebut ,:datefin , :description)");
                $stmt->execute([
                    ':titre' => $activitieName,
                    ':ville_id' => $activitieCity,
                    ':price' => $activitiePrice,
                    ':datedebut' => $dateDebut,
                    ':datefin' => $dateFin,
                    ':description' => $activitieDescription
                ]);
                $activitieId = $conn->lastInsertId();
                foreach ($imagesUrls as $imageUrl) {
                    $stmt = $conn->prepare("INSERT INTO images_activites (activite_id, urlSrc, altText) VALUES (:activite_id, :urlSrc , :altText)");
                    $stmt->execute([
                        ':activite_id' => $activitieId,
                        ':urlSrc' => $imageUrl,
                        ':altText' => $activitieName
                    ]);
                }
                header("Location:../../../frontend/admin/dashboard.php?success=Activité ajoutée avec succès");
                exit();
                }
            
        }

?>