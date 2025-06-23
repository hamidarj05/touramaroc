

<?php
$form = isset($_GET["form"]) ? $_GET["form"] : "";




?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <title>TouraMaroc - Événements</title>
    <style>
        :root {
            --primary: #2A4BA5;
            --primary-dark: #1a3a8f;
            --secondary: #a05c21;
            --accent: #D57C34;
            --light: #fffdf7;
            --dark: #4e342e;
            --gray: #6d4c41;
            --light-gray: #f7efe7;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7ff;
            padding-top: 80px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .page-header h1 span {
            color: var(--primary);
            position: relative;
        }

        .page-header h1 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--accent);
            border-radius: 3px;
            transform: scaleX(0.8);
            transform-origin: center;
        }

        .page-header p.subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        } */

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        h1 {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            margin-bottom: 2rem;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            display: inline-block;
        }

        h1 span {
            color: var(--primary);
        }

        .search-container {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .search-container input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .search-container input:focus {
            outline: none;
            box-shadow: var(--shadow-md);
        }

        .search-container select {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            cursor: pointer;
        }

        .search-container select:focus {
            outline: none;
            box-shadow: var(--shadow-md);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .event-card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .event-date {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .event-badge {
            background: var(--light-gray);
            color: var(--dark);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .event-card h3 {
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
            color: var(--dark);
            font-weight: 700;
        }

        .event-location {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray);
            margin-bottom: 1.25rem;
            font-size: 0.95rem;
        }

        .event-location i {
            color: var(--accent);
        }

        .event-card p {
            color: var(--gray);
            margin-bottom: 2rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .view-details {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            align-self: flex-start;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: auto;
        }

        .view-details:hover {
            background: var(--primary-dark);
            transform: translateX(5px);
        }

        .view-details i {
            transition: var(--transition);
        }

        .view-details:hover i {
            transform: translateX(3px);
        }

        .no-events {
            grid-column: 1 / -1;
            text-align: center;
            color: var(--gray);
            padding: 3rem;
            font-size: 1.1rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            position: relative;
            animation: slideUp 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.75rem;
            cursor: pointer;
            color: var(--gray);
            transition: var(--transition);
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-modal:hover {
            color: var(--dark);
            background: var(--light-gray);
        }

        .modal-header {
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .modal-header h2 {
            font-size: 1.75rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .event-meta {
            display: flex;
            gap: 1.5rem;
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .event-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .event-meta i {
            color: var(--accent);
        }

        .modal-body {
            padding: 1.5rem 2rem;
        }

        .modal-body p {
            color: var(--gray);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            white-space: pre-line;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
        }

        #reservationModal .modal-content {
            max-width: 700px;
        }

        #reservationModal .modal-header {
            padding-bottom: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin: 1.5rem 0;
            padding: 0 2rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            padding: 0 2rem 2rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--light-gray);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                gap: 1rem;
            }

            .search-box {
                min-width: 100%;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
                padding: 0 1.5rem;
            }

            .modal-actions,
            .form-actions {
                flex-direction: column;
                gap: 1rem;
                padding: 0 1.5rem 1.5rem;
            }

            .modal-header {
                padding: 1.5rem 1.5rem 1rem;
            }

            .modal-body {
                padding: 1rem 1.5rem;
            }

            .form-actions {
                padding-bottom: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include '../../components/nav.php' ?>

    <main class="container">
        <header class="page-header">
            <h1>Nos <span>Événements</span></h1>
            <p class="subtitle">Découvrez les expériences uniques qui vous attendent à travers le Maroc</p>
        </header>

        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un événement...">
            </div>
            <select id="cityFilter">
                <option value="">Toutes les villes</option>
                <?php
                include '../../../../db/connectDB.php';
                $cities = $conn->query("SELECT ville_id, nom FROM villes ORDER BY nom");
                while ($city = $cities->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $city['ville_id'] . '">' . $city['nom'] . '</option>';
                }
                ?>
            </select>
            <select id="dateFilter">
                <option value="">Toutes dates</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="upcoming">À venir</option>
            </select>
        </div>

        <div class="events-grid" id="eventsContainer">
            <?php
            $sql = "
                SELECT 
                    e.id_evenement,
                    e.nom,
                    e.lieu,
                    e.description_evenement,
                    e.dateDebut,
                    e.dateFin,
                    v.nom AS nom_ville
                FROM evenements e
                LEFT JOIN villes v ON e.lieu = v.ville_id
                WHERE e.dateFin >= CURDATE()
                ORDER BY e.dateDebut ASC
                LIMIT 9
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($evenements) {
                foreach ($evenements as $event) {
                    $startDate = date('d M', strtotime($event["dateDebut"]));
                    $endDate = date('d M', strtotime($event["dateFin"]));

                    echo '<div class="event-card" 
                            data-id="' . $event["id_evenement"] . '"
                            data-city="' . $event["lieu"] . '"
                            data-startdate="' . $event["dateDebut"] . '"
                            data-enddate="' . $event["dateFin"] . '"
                            data-searchtext="' . strtolower($event["nom"] . ' ' . $event["nom_ville"]) . '">
                            <div class="event-header">
                                <div class="event-date">' . $startDate . ($startDate != $endDate ? ' - ' . $endDate : '') . '</div>
                                <div class="event-badge">Événement</div>
                            </div>
                            <h3>' . $event["nom"] . '</h3>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                ' . $event["nom_ville"] . '
                            </div>
                            <p>' . substr($event["description_evenement"], 0, 100) . '...</p>
                            <a href="index.php?form=Reserve&nom='.$event["nom"].'&dateDebut='.$event["dateDebut"].'&dateFin='.$event["dateFin"].' class="btn btn-primary">Reserver <i class="fas fa-arrow-right"></i></a>
                        </div>';
                }
            } else {
                echo '<p class="no-events">Aucun événement à venir trouvé.</p>';
            }
            ?>
        </div>
    </main>
 
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h2 id="eventTitle"></h2>
                <div class="event-meta">
                    <span id="eventDate"></span>
                    <span id="eventLocation"></span>
                </div>
            </div>
            <div class="modal-body">
                <p id="eventDescription"></p>
                <div class="modal-actions">
                    <button class="btn-secondary close-details" id="closeDetails">Retour</button>
                    <a href="../evenement/index.php?form=Reserve&nom=<?= $item['nom'] ?>&dateDebut=<?= $item['dateDebut'] ?>&dateFin=<?= $item['dateFin'] ?>" class="btn-primary" id="reserveNow">Réserver maintenant</a>
                </div>
            </div>
        </div>
    </div>



    <?php include '../../components/footer.php' ?>

    <?php if ($form == "Reserve"): ?>
        <?php
        $type =  $_GET["nom"];
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
    
</body>

</html>