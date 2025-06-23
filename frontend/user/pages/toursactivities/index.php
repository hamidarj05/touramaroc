<?php
include '../../../../db/connectDB.php';

$conditionsTour = [];
$conditionsActivite = [];
$params = [];
// $id = $_SESSION["idUser"];
$form = isset($_GET["form"]) ? $_GET["form"] : "";

if (!empty($_GET['ville_id'])) {
    $conditionsTour[] = "t.ville_id = :ville_id";
    $conditionsActivite[] = "a.ville_id = :ville_id";
    $params[':ville_id'] = $_GET['ville_id'];
}

if (!empty($_GET['date_debut']) && !empty($_GET['date_fin'])) {
    $conditionsTour[] = "(t.dateDebut <= :date_fin AND t.dateFin >= :date_debut)";
    $conditionsActivite[] = "(a.dateDebut <= :date_fin AND a.dateFin >= :date_debut)";
    $params[':date_debut'] = $_GET['date_debut'];
    $params[':date_fin'] = $_GET['date_fin'];
}



$sqlTour = "
    SELECT 
        'tour' AS type,
        t.tour_id AS id,
        t.titre,
        t.prix,
        t.dateDebut,
        t.dateFin,
        t.tour_description AS description,
        v.nom AS ville_nom,
        img.urlSrc,
        img.altText
    FROM tours t
    JOIN villes v ON t.ville_id = v.ville_id
    LEFT JOIN images_tour img ON img.tour_id = t.tour_id
";

if (!empty($conditionsTour)) {
    $sqlTour .= " WHERE " . implode(" AND ", $conditionsTour);
}

$sqlTour .= " GROUP BY t.tour_id";

$sqlActivite = "
    SELECT 
        'activite' AS type,
        a.activite_id AS id,
        a.titre,
        a.prix,
        a.dateDebut,
        a.dateFin,
        a.activite_description AS description,
        v.nom AS ville_nom,
        img.urlSrc,
        img.altText
    FROM activites a
    JOIN villes v ON a.ville_id = v.ville_id
    LEFT JOIN images_activites img ON img.activite_id = a.activite_id
";

if (!empty($conditionsActivite)) {
    $sqlActivite .= " WHERE " . implode(" AND ", $conditionsActivite);
}

$sqlActivite .= " GROUP BY a.activite_id";
$sql = "($sqlTour) UNION ($sqlActivite) ORDER BY dateDebut DESC LIMIT 8";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);



$villes = [];
try {
    $stmt = $conn->prepare("SELECT ville_id, nom FROM villes ORDER BY nom ASC");
    $stmt->execute();
    $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TouraMaroc</title>
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style>
        * {
            text-transform: capitalize;
        }

        .herbergementHeroImage {
            width: 100%;
            min-height: calc(100vh - 300px);
            position: relative;
            padding: 60px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .herbergementHeroImage img {
            position: absolute;
            inset: 0;
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            border-radius: 0 0 0 55px;
        }

        .herbergementHeroImage:before {
            content: "";
            background: color-mix(in srgb, rgba(0, 27, 68, 0.9), transparent 65%);
            position: absolute;
            inset: 0;
            z-index: 2;
            border-radius: 0 0 0 55px;
        }

        .herbergementHeroImage .titre-heber {
            position: absolute;
            top: 30%;
            z-index: 3;
        }

        .herbergementHeroImage h3 {
            font-size: 29px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .herbergementHeroImage h3 {
                font-size: 29px;
            }
        }
    </style> 
</head>

<div>
    <?php include '../../components/nav.php' ?>
    <section id="herbergementHeroImage" class="herbergementHeroImage section dark-background">
        <h2 class="titre-heber" style='color: white;'>
            Vivez plus, dépensez moins : explorez avec nos activités !
        </h2>
        <img src='../../media/images/herbergementHeroImage.png' alt="Hero" />
    </section>
    <section class="bg-light py-4">
        <div class="container shadow p-4 rounded bg-white">
            <ul class="nav nav-tabs mb-3 justify-content-center border-bottom">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Tours & Activités</a>
                </li>
            </ul>

            <form method="GET" action="index.php">
                <div class="row g-3 align-items-center">
                    <!-- FINAWA GHADI -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-text bg-white border-end-0"><i class="bi bi-geo-alt-fill"></i></label>
                            <select name="ville_id" class="form-select border-start-0" required>
                                <option value="" selected disabled>Choisir une ville</option>
                                <?php foreach ($villes as $ville): ?>
                                    <option value="<?= $ville['ville_id'] ?>"><?= $ville['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Date li ghadi fiha -->
                    <div class="col-md-4 d-flex gap-2">
                        <input type="date" name="date_debut" class="form-control" value="<?= date('Y-m-d') ?>">
                        <input type="date" name="date_fin" class="form-control" value="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                    </div>

                    <!-- Yallah -->
                    <div class="col-md-2 text-center">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">C’EST PARTI !</button>
                    </div>

                </div>
            </form>
        </div>
    </section>
    <section class="bg-white mt-4 px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Tours & Activités</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($items as $item): ?>
                    <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition duration-300">
                        <img src="../../../../backend/admin/pages/uploads/<?= $item['urlSrc'] ?>" alt="<?= $item['altText'] ?>" class="w-full h-52 object-cover">
                        <div class="p-4">
                            <span class="text-xs uppercase tracking-wide text-indigo-600 font-medium"><?= $item['type'] ?></span>
                            <h3 class="text-lg font-semibold text-gray-800 mt-1"><?= $item['titre'] ?></h3>
                            <p class="text-sm text-gray-600"><?= $item['ville_nom'] ?></p>
                            <p class="text-sm text-gray-500 mt-1"><?= $item['prix'], 0, ',', ' ' ?> MAD</p>
                            <p class="text-xs text-gray-400 mt-2"><?= date('d M', strtotime($item['dateDebut'])) ?> → <?= date('d M', strtotime($item['dateFin'])) ?></p>
                            <p class="text-sm text-gray-500 mt-2"><?= $item['description'] ?>...</p>
                            <a href="../toursactivities/index.php?form=Reserve&type=<?= $item['type'] ?>&dateDebut=<?= $item['dateDebut'] ?>&dateFin=<?= $item['dateFin'] ?>" class="mt-3 inline-block text-sm text-indigo-600 hover:underline btn btn-primary">Rerever</a>
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
        $type =  $_GET["type"];
        $idUser = 1;
        $dateDebut = $_GET["dateDebut"];
        $dateFin = $_GET["dateFin"];
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
                                <input type="hidden" class="form-control" name="dateDebut" value="<?= $dateDebut ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="dateFin" value="<?= $dateFin ?>" required>
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