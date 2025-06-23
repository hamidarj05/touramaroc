<?php
require_once '../../../db/connectDB.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tourName = $_POST['tourName'];
            $tourCity = $_POST['tourCity'];
            $tourPrice = $_POST['tourPrice'];
            $dateDebut = $_POST['dateDebut'];
            $dateFin = $_POST['dateFin'];
            $tourDescription = $_POST['tourDescription'];
            $tourImages = $_FILES['tourImages']; 
            $imagesUrls = [];
            for ($i = 0; $i < count($tourImages['name']); $i++) {
                if (!empty($tourImages['tmp_name'][$i])) {
                    $tmpName = $tourImages['tmp_name'][$i];
                    $fileName = $tourImages['name'][$i];
                    move_uploaded_file($tmpName, 'uploads/' . $fileName);
                    $imagesUrls[] = $fileName; 
                }
            }
            if(isset($_GET["EditTour"])){
                $idEdittour = $_GET['idEditTour'];
                $stmt = $conn->prepare("UPDATE tours SET titre = :titre, ville_id = :ville_id, prix = :price, dateDebut = :datedebut, dateFin = :datefin, tour_description = :description 
                                            WHERE tour_id = :id");
                $stmt->execute([
                    ':titre' => $tourName,
                    ':ville_id' => $tourCity,
                    ':price' => $tourPrice,
                    ':datedebut' => $dateDebut,
                    ':datefin' => $dateFin,
                    ':description' => $tourDescription,
                    ':id' => $idEdittour
                ]);
                foreach ($imagesUrls as $imageUrl) {
                    $stmt = $conn->prepare("DELETE FROM images_tour WHERE tour_id = :id");
                    $stmt->execute([':id' => $idEdittour]);
                    $stmt = $conn->prepare("INSERT INTO images_tour (tour_id, urlSrc, altText) VALUES (:tour_id, :urlSrc , :altText)");
                    $stmt->execute([
                        ':tour_id' => $idEdittour,
                        ':urlSrc' => $imageUrl,
                        ':altText' => $tourName
                    ]);
                }
                header("Location:../../../frontend/admin/dashboard.php?page=tours&success=Tours modifiée avec succès");
                exit();

            }else{
                $stmt = $conn->prepare("INSERT INTO tours (titre, ville_id, prix, dateDebut, dateFin, tour_description) 
                                            VALUES (:name, :ville_id, :price, :date_debut, :date_fin, :description)");
                $stmt->execute([
                    ':name' => $tourName,
                    ':ville_id' => $tourCity,
                    ':price' => $tourPrice,
                    ':date_debut' => $dateDebut,
                    ':date_fin' => $dateFin,
                    ':description' => $tourDescription
                ]);
                $tourId = $conn->lastInsertId();
                foreach ($imagesUrls as $imageUrl) {
                    $stmt = $conn->prepare("INSERT INTO images_tour (tour_id, urlSrc, altText) 
                                    VALUES (:tour_id, :urlSrc , :altText)");
                    $stmt->execute([
                        ':tour_id' => $tourId,
                        ':urlSrc' => $imageUrl,
                        ':altText' => $tourName
                    ]);
                }
                header("Location:../../../frontend/admin/dashboard.php?success=Tour ajouté avec succès");
                exit();
            }
        }  