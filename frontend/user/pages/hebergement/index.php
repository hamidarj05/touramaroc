<?php
include '../../../../db/connectDB.php';

$form = isset($_GET["form"]) ? $_GET["form"] : "";


$sql = "
    SELECT 
        h.id,
        h.hebergement_id,
        h.type,
        COALESCE(ho.nom, ri.nom, ma.nom) AS nom,
        COALESCE(ho.prix, ri.prix, ma.prix) AS prix,
        COALESCE(ho.ville_id, ri.ville_id, ma.ville_id) AS ville_id,
        v.nom AS ville_nom,
        img.urlSrc,
        img.alt
    FROM hebergements h
    LEFT JOIN hotel ho ON ho.id = h.hebergement_id AND h.type = 'hotel'
    LEFT JOIN riads ri ON ri.id = h.hebergement_id AND h.type = 'riad'
    LEFT JOIN maison ma ON ma.id = h.hebergement_id AND h.type = 'maison'
    LEFT JOIN villes v ON v.ville_id = COALESCE(ho.ville_id, ri.ville_id, ma.ville_id)
    LEFT JOIN hebergement_images img ON img.hebergement_id = h.id
    ORDER BY h.type
    LIMIT 6
";


$stmt = $conn->prepare($sql);
$stmt->execute();
$hebergements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <title>Document</title>
</head>

<body>
    <div>
        <?php include '../../components/nav.php' ?>

        <section id="herbergementHeroImage" class="herbergementHeroImage section dark-background">
            <h2 class="titre-heber" style='color: white;'>
                Voir le monde à moindre coût
            </h2>
            <img src='../../media/images/herbergementHeroImage.png' alt="Hero" />
        </section>
        <section class="bg-white py-12 px-6">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-8"> Nos Hébergements</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php foreach ($hebergements as $h): ?>
                        <div class="bg-gray-50 rounded-xl overflow-hidden shadow hover:shadow-lg transition duration-300">
                            <img src="../../../../backend/admin/pages/uploads/<?= $h["urlSrc"] ?>" alt="<?= $h["alt"]  ?>" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <span class="text-xs text-indigo-600 uppercase font-semibold"><?= $h["type"] ?></span>
                                <h3 class="text-lg font-semibold text-gray-900"><?= $h["nom"] ?></h3>
                                <p class="text-sm text-gray-600">📍 <?= $h["ville_nom"]  ?></p>
                                <p class="text-sm text-gray-800 mt-1"><?= $h["prix"], 0, ',', ' ' ?> MAD / nuit</p>
                                <a href="index.php?form=Reserve&nom=<?=$h["nom"]?>" class="inline-block mt-3 text-indigo-600 hover:underline text-sm">
                                    Reserver
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php include '../../components/footer.php' ?>
        <script src="https://cdn.tailwindcss.com"></script>
        <?php if ($form == "Reserve"): ?>
        <?php
        $type =  $_GET["nom"];
        $idUser = 1;  
        ?>

        <script>
            window.onload = function() {
                var myModal = new bootstrap.Modal(document.getElementById('reservationModal'));
                myModal.show();
            };
        </script>

        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="../../../../backend/admin/pages/gererReservation.php?addReservation"
                        method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reservationModalLabel">Reserver <?php echo $type ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" value=<?php echo $type ?> name="reservType">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" value=<?php echo $idUser ?> name="userId">
                            </div>
                            <div class="mb-3">
                                <label for="dateDebut">date Debut</label>
                                <input type="date" class="form-control" name="dateDebut" id="dateDebut"  required>
                            </div>
                            <div class="mb-3">
                                <label for="dateFin">date Debut</label>
                                <input type="date" class="form-control" id="dateFin" name="dateFin" required>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" value="en attente" name="statut">
                            </div>
                            <div class="mb-3">
                                <label for="statut" class="form-label text-center">Confimer✅</label> <br>
                                <input type="submit" value="OK" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <div class="alert-hkk">
        <?php if (isset($_GET['success'])) {
            $success = $_GET['success'];
            echo "<p class='alert alert-success alertFo9' 
                    style='padding: 10px 20px;
                    font-size: 20px;
                    position: fixed;
                    top: 20px;
                    left: 40%;
                    z-index: 9999;'
                    >$success</p>";
        }
        ?>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-hkk');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
    </div>
</body>

</html>