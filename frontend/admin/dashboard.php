<?php
session_start();
// if ($_SESSION['role'] != "admin"){
//     header("Location: ../login.php");
//     exit();
// }

include_once '../../db/connectDB.php';
require_once '../../backend/class/Blog.php'; 



$blog = new Blog($conn);

// Flash messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

// Clear flash messages
unset($_SESSION['success'], $_SESSION['error']);

// Get all blog posts
try {
    $blogs = $blog->obtenirTousArticles();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error = "Failed to load blog posts. Please try again later.";
    $blogs = [];
}

// Handle bulk actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action'])) {
    $action = $_POST['bulk_action'];
    $selected = $_POST['selected'] ?? [];

    if (!empty($selected)) {
        try {
            foreach ($selected as $id) {
                if (ctype_digit($id)) {
                    $id = (int)$id;

                    if ($action === 'delete') {
                        $post = $blog->obtenirArticleParId($id);
                        if ($post && $blog->supprimerArticle($id)) {
                            // Delete associated image
                            if (!empty($post['image'])) {
                                $imagePath = realpath(__DIR__ . '/../../../uploads/blogs/' . $post['image']);
                                if ($imagePath && file_exists($imagePath) && is_writable($imagePath)) {
                                    unlink($imagePath);
                                }
                            }
                        }
                    }
                }
                header("Location:dashboard.php?page=blogs&success=blog A ete Supprimer");
            }
        } catch (PDOException $e) {
            error_log("Bulk action error: " . $e->getMessage());
            $_SESSION['error'] = "Failed to complete bulk action";
        }
    }
}


$stmt = $conn->query("SELECT COUNT(*) FROM users");
$UserNbr = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) FROM reservations");
$ReservationNbr = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT SUM(montant) FROM paiements WHERE statut = :statut");
$stmt->execute([':statut' => 'réussi']);
$RevenueNbr = $stmt->fetchColumn();


if ($UserNbr === null) $UserNbr = 0;
if ($ReservationNbr === null) $ReservationNbr = 0;
if ($RevenueNbr === null) $RevenueNbr = 0;

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$form = isset($_GET['form']) ? $_GET['form'] : '';

$stmt = $conn->query("SELECT * FROM villes");
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM activites");
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM tours");
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM evenements");
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);


switch ($form) {
    case 'deleteVille':
        $stmt = $conn->prepare("DELETE FROM villes WHERE ville_id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=villes&success=Ville A ete Supprimer");
        break;
    case 'deleteMessage':
        $stmt = $conn->prepare("DELETE FROM contact WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=messages&success=Message A ete Supprimer");
        break;
    case 'deleteReservation':
        $stmt = $conn->prepare("DELETE FROM reservations WHERE id_reservation = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=reservations&success=reservation A ete Supprimer");
        break;
    case 'deleteUser':
        $stmt = $conn->prepare("DELETE FROM users WHERE id_user = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location: dashboard.php?page=users&success=Utilisateur supprimé avec succès");
        break;

    case 'deleteBlog':
        $blog->supprimerArticle($_GET['id']);
        header('Location:dashboard.php?page=blogs&success=blog a ete supprimer');
        exit();
    case 'deleteActivitie':
        $stmt = $conn->prepare("DELETE FROM activites WHERE activite_id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=activiteis&success=activite A ete Supprimer");
        break;
    case 'deleteTour':
        $stmt = $conn->prepare("DELETE FROM tours WHERE tour_id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=tours&success=tour A ete Supprimer");
        break;
    case 'deleteevenement':
        $stmt = $conn->prepare("DELETE FROM evenements WHERE id_evenement = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:dashboard.php?page=events&success=evenement A ete Supprimer");
        break;
    case 'deleteHebergement':
        $stmt = $conn->prepare("DELETE FROM hebergements WHERE type = :type and hebergement_id = :id");
        $stmt->execute([':id' => $_GET['id'], ':type' => $_GET['type']]);

        $stmt = $conn->prepare("SELECT * FROM hebergements WHERE type = :type and hebergement_id = :id");
        $stmt->execute([':id' => $_GET['id'], ':type' => $_GET['type']]);
        $hebergement = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("DELETE FROM detail_hebergements where id_hebergement = :id");
        $stmt->execute([':id' => $hebergement["id"]]);

        $stmt = $conn->prepare("DELETE FROM hebergement_images where hebergement_id = :id");
        $stmt->execute([':id' => $hebergement["id"]]);
        switch ($_GET["type"]) {
            case 'hotel':
                $stmt = $conn->prepare("DELETE FROM hotel WHERE id = :id");
                $stmt->execute([':id' => $_GET['id']]);
                break;
            case 'riad':
                $stmt = $conn->prepare("DELETE FROM riads WHERE id = :id");
                $stmt->execute([':id' => $_GET['id']]);
                break;
            case 'maison':
                $stmt = $conn->prepare("DELETE FROM maison WHERE id = :id");
                $stmt->execute([':id' => $_GET['id']]);
                break;
        }
        header("Location:dashboard.php?page=hebergements&success=hebergement A ete Supprimer");
        break;
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Tour a Maroc Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .alertFo9 {
            padding: 10px 20px;
            font-size: 20px;
            position: fixed;
            top: 20px;
            left: 50%;
            z-index: 9999;
        }
    </style>
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table img {
            max-width: 100px;
            max-height: 60px;
            object-fit: cover;
        }

        .action-buttons {
            white-space: nowrap;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
        }
    </style>
    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin-top: 10px;
        }

        .current-image {
            max-width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <!-- NAV JNB -->
        <aside id="sidebar">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="sidebar-logo">
                    <a href="#" class="text-white text-decoration-none fs-5 fw-bold">TouraMaroc</a>
                </div>
                <button class="toggle-btn border-0 bg-transparent" type="button">
                    <i id="sidebar-toggle" class='bx bx-menu text-white'></i>
                </button>
            </div>
            <ul class="sidebar-nav px-2">
                <li class="sidebar-item active">
                    <a href="dashboard.php?page=home" class="sidebar-link">
                        <i class='bx bxs-dashboard'></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=users" class="sidebar-link">
                        <i class='bx bxs-user'></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=blogs" class="sidebar-link">
                        <i class='bxr  bx-bookmark-alt'  ></i> 
                        <span>Blogs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=villes" class="sidebar-link">
                        <i class='bxr bx-map-pin'></i>
                        <span>Villes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=activiteis" class="sidebar-link">
                        <i class='bx  bx-dice-5'></i>
                        <span>Activities</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=tours" class="sidebar-link">
                        <i class='bx  bx-trip'></i>
                        <span>Tours</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=events" class="sidebar-link">
                        <i class='bx  bx-calendar-week'></i>
                        <span>Events</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=hebergements" class="sidebar-link">
                        <i class='bx  bx-building-house'></i>
                        <span>Hebergements</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=reservations" class="sidebar-link">
                        <i class='bx bxs-calendar-check'></i>
                        <span>Réservations</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=paiments" class="sidebar-link">
                        <i class='bx bxs-calendar-check'></i>
                        <span>Paiment</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=messages" class="sidebar-link">
                        <i class='bx bxs-comment-detail'></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="sidebar-item mt-4">
                    <a href="dashboard.php?page=home" class="sidebar-link">
                        <i class='bx bxs-cog'></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- CONTENUE WASTT -->
        <div class="main">
            <?php if ($page == 'home'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" id="page-title">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <!-- DASHBOARD 7SSAB-->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Utilisateurs</h6>
                                            <h3 class="mb-0">
                                                <?php echo $UserNbr ?>
                                            </h3>
                                        </div>
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                            <i class='bx bxs-user text-primary fs-4'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Réservations</h6>
                                            <h3 class="mb-0">
                                                <?php echo $ReservationNbr ?>
                                            </h3>
                                        </div>
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                            <i class='bx bxs-calendar-check text-success fs-4'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Revenus</h6>
                                            <h3 class="mb-0">
                                                <?php echo $RevenueNbr ?>
                                            </h3>
                                        </div>
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                            <i class='bx bxs-wallet text-info fs-4'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIVITIES -->
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm h-100">
                                <div
                                    class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Activités récentes</h6>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                                </div>
                                <div class="card-body">
                                    <div class="activity-item d-flex mb-4">
                                        <div class="activity-icon bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class='bx bxs-user-plus text-primary'></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0"><strong>Nouvel utilisateur</strong> enregistré</p>
                                            <small class="text-muted">Il y a 5 minutes</small>
                                        </div>
                                    </div>
                                    <div class="activity-item d-flex mb-4">
                                        <div class="activity-icon bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class='bx bxs-calendar-check text-success'></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0"><strong>Nouvelle réservation</strong> #12345</p>
                                            <small class="text-muted">Il y a 1 heure</small>
                                        </div>
                                    </div>
                                    <div class="activity-item d-flex mb-4">
                                        <div class="activity-icon bg-warning bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class='bx bxs-comment-detail text-warning'></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0"><strong>Nouveau commentaire</strong> sur le circuit "Marrakech
                                                Express"</p>
                                            <small class="text-muted">Il y a 3 heures</small>
                                        </div>
                                    </div>
                                    <div class="activity-item d-flex">
                                        <div class="activity-icon bg-info bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class='bx bxs-envelope text-info'></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0"><strong>Nouveau message</strong> de contact@client.com</p>
                                            <small class="text-muted">Il y a 5 heures</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LIEN DZRBA -->

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0">Actions rapides</h6>
                                </div>
                                <div class="card-body">
                                    <a class="btn btn-primary w-100 mb-3" href="dashboard.php?form=addVille">
                                        <i class='bx bx-plus me-2'></i>Nouveau ville
                                    </a>
                                    <a class="btn btn-primary w-100 mb-3" href="dashboard.php?form=addTour">
                                        <i class='bx bx-plus me-2'></i>Nouveau Tour
                                    </a>
                                    <a class="btn btn-primary w-100 mb-3" href="dashboard.php?form=addHebergement">
                                        <i class='bx bx-plus me-2'></i>Nouveau Hebergement
                                    </a>
                                    <a class="btn btn-primary w-100 mb-3" href="dashboard.php?form=addActivitie">
                                        <i class='bx bx-plus me-2'></i>Nouveau Activitie
                                    </a>
                                    <a class="btn btn-primary w-100 mb-3" href="dashboard.php?form=addEvent">
                                        <i class='bx bx-plus me-2'></i>Nouveau Event
                                    </a>
                                    <a class="btn btn-outline-secondary w-100 mb-3"
                                        href="dashboard.php?form=generateReport">
                                        <i class='bx bx-file me-2'></i>Générer un rapport
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php elseif ($page == 'reservations'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" id="page-title">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <?php
                $stmt = $conn->query("SELECT r.*, CONCAT(u.prenom, ' ', u.nom) AS nom_complet 
                      FROM reservations r 
                      JOIN users u ON r.user_id = u.id_user 
                      ORDER BY r.id_reservation DESC");
                $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="container-fluid p-4" id="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Réservations</h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Client</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $res): ?>
                                <tr>
                                    <td><?= htmlspecialchars($res['reserv_type']) ?></td>
                                    <td><?= htmlspecialchars($res['nom_complet']) ?></td>
                                    <td><?= htmlspecialchars($res['date_debut']) ?></td>
                                    <td><?= htmlspecialchars($res['date_fin']) ?></td>
                                    <td><?= htmlspecialchars($res['statut']) ?></td>
                                    <td>
                                        <a href="dashboard.php?page=reservations&form=editReservation&idEditReservation=<?php echo $res['id_reservation'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?page=reservations&form=deleteReservation&id=<?php echo $res['id_reservation'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            <?php elseif ($page == 'messages'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <?php
                $stmt = $conn->query("SELECT * FROM contact ORDER BY id DESC");
                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="container-fluid p-4" id="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Messages</h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Sujet</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><?= htmlspecialchars($msg['nom']) ?></td>
                                    <td><?= htmlspecialchars($msg['email']) ?></td>
                                    <td><?= htmlspecialchars($msg['sujet']) ?></td>
                                    <td><?= htmlspecialchars($msg['message']) ?></td>
                                    <td>
                                        <a href="dashboard.php?page=messages&form=deleteMessage&id=<?= $msg['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($page == "users") : ?>
                <!-- NAVIGATION -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <!-- Notifications -->
                            ...
                            <!-- Profil Admin -->
                            ...
                        </div>
                    </div>
                </nav>

                <!-- CONTENU PRINCIPAL -->
                <div class="container-fluid p-4" id="main-content">
                    <?php
                    $stmt = $conn->query("SELECT * FROM users");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Utilisateurs</h3>
                        <a href="dashboard.php?page=users&form=addUser" class="btn btn-success">Ajouter un utilisateur</a>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Pays</th>
                                <th>Ville</th>
                                <th>Adresse</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['nom']) ?></td>
                                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['telephone']) ?></td>
                                    <td><?= htmlspecialchars($user['pays']) ?></td>
                                    <td><?= htmlspecialchars($user['ville']) ?></td>
                                    <td><?= htmlspecialchars($user['adresse']) ?></td>
                                    <td><?= htmlspecialchars($user['user_role']) ?></td>
                                    <td>
                                        <a href="dashboard.php?page=users&form=editUser&id=<?= $user['id_user'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?page=users&form=deleteUser&id=<?= $user['id_user'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($page == 'villes'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <!-- Table d les villes -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Villes</h3>
                        <a class="btn btn-success" href="dashboard.php?page=villes&form=addVille">
                            <i class="bi bi-plus-circle"></i> Ajouter une Ville
                        </a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom de la Ville</th>
                                <th>Description</th>
                                <th>Coordonnées</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cities as $city): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($city['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($city['ville_description']); ?></td>
                                    <td><?php echo htmlspecialchars($city['coordonnees']); ?></td>
                                    <td>
                                        <a href="dashboard.php?page=villes&form=EditVille&idEditVille=<?php echo $city['ville_id']; ?>"
                                            class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?form=deleteVille&id=<?php echo $city['ville_id']; ?>"
                                            class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($page == 'activiteis'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <!-- Table dles Activités -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Activités</h3>
                        <a class="btn btn-success" href="dashboard.php?page=activiteis&form=addActivitie">
                            <i class="bi bi-plus-circle"></i> Ajouter une Activité
                        </a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom de l'Activité</th>
                                <th>Ville</th>
                                <th>Prix</th>
                                <th>date Debut</th>
                                <th>date Fin</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($activity['titre']); ?></td>
                                    <?php
                                    $stmt = $conn->prepare("SELECT nom FROM villes WHERE ville_id = :ville_id");
                                    $stmt->execute([':ville_id' => $activity['ville_id']]);
                                    $ville = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($ville) {
                                        $villeNom = $ville['nom'];
                                    } else {
                                        $villeNom = 'Inconnu';
                                    }
                                    ?>
                                    <td><?php echo $villeNom  ?></td>
                                    <td><?php echo htmlspecialchars($activity['prix']); ?> MAD</td>
                                    <td><?php echo htmlspecialchars($activity['dateDebut']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['dateFin']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['activite_description']); ?></td>
                                    <td>
                                        <a href="dashboard.php?page=activiteis&form=EditActivitie&idEditActivitie=<?php echo $activity['activite_id']; ?>"
                                            class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?pages=activiteis&form=deleteActivitie&id=<?php echo $activity['activite_id']; ?>"
                                            class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($page == 'tours'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <!-- Table dles Activités -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des tours</h3>
                        <a class="btn btn-success" href="dashboard.php?page=tours&form=addTour">
                            <i class="bi bi-plus-circle"></i> Ajouter une tour
                        </a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom de tour</th>
                                <th>Ville</th>
                                <th>Prix</th>
                                <th>date Debut</th>
                                <th>date Fin</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tours as $tour): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($tour['titre']); ?></td>
                                    <?php
                                    $stmt = $conn->prepare("SELECT nom FROM villes WHERE ville_id = :ville_id");
                                    $stmt->execute([':ville_id' => $tour['ville_id']]);
                                    $ville = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($ville) {
                                        $villeNom = $ville['nom'];
                                    } else {
                                        $villeNom = 'Inconnu';
                                    }
                                    ?>
                                    <td><?php echo $villeNom  ?></td>
                                    <td><?php echo htmlspecialchars($tour['prix']); ?> MAD</td>
                                    <td><?php echo htmlspecialchars($tour['dateDebut']); ?></td>
                                    <td><?php echo htmlspecialchars($tour['dateFin']); ?></td>
                                    <td><?php echo htmlspecialchars($tour['tour_description']); ?></td>
                                    <td>
                                        <a href="dashboard.php?page=tours&form=EditTours&idEditTours=<?php echo $tour['tour_id']; ?>"
                                            class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?pages=tours&form=deleteTour&id=<?php echo $tour['tour_id']; ?>"
                                            class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($page == "events"): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <!-- Table dles Activités -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des evenements</h3>
                        <a class="btn btn-success" href="dashboard.php?page=events&form=addEvent">
                            <i class="bi bi-plus-circle"></i> Ajouter une evenement
                        </a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom de l'evenements</th>
                                <th>Ville</th>
                                <th>Description</th>
                                <th>date Debut</th>
                                <th>date Fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evenements as $evenement): ?>
                                <tr>
                                    <td><?php echo $evenement['nom']; ?></td>
                                    <?php
                                    $stmt = $conn->prepare("SELECT nom FROM villes WHERE ville_id = :ville_id");
                                    $stmt->execute([':ville_id' => $evenement['lieu']]);
                                    $ville = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($ville) {
                                        $villeNom = $ville['nom'];
                                    } else {
                                        $villeNom = 'Inconnu';
                                    }
                                    ?>
                                    <td><?php echo $villeNom  ?></td>
                                    <td><?php echo htmlspecialchars($evenement['description_evenement']); ?></td>
                                    <td><?php echo htmlspecialchars($evenement['dateDebut']); ?></td>
                                    <td><?php echo htmlspecialchars($evenement['dateFin']); ?></td>
                                    <td>
                                        <a href="dashboard.php?page=events&form=Editevenement&idEditevenement=<?php echo $evenement['id_evenement']; ?>"
                                            class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?pages=events&form=deleteevenement&id=<?php echo $evenement['id_evenement']; ?>"
                                            class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($page == 'hebergements'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- CONTENUE D PAGE -->
                <?php
                $hotels = $conn->query("SELECT h.id, h.nom, h.prix, h.etoiles AS rating, v.nom AS ville, 'hotel' AS type 
                        FROM hotel h 
                        JOIN villes v ON h.ville_id = v.ville_id")->fetchAll(PDO::FETCH_ASSOC);

                $riads = $conn->query("SELECT r.id, r.nom, r.prix, NULL AS rating, v.nom AS ville, 'riad' AS type 
                       FROM riads r 
                       JOIN villes v ON r.ville_id = v.ville_id")->fetchAll(PDO::FETCH_ASSOC);

                $maisons = $conn->query("SELECT m.id, m.nom, m.prix, NULL AS rating, v.nom AS ville, 'maison' AS type 
                         FROM maison m 
                         JOIN villes v ON m.ville_id = v.ville_id")->fetchAll(PDO::FETCH_ASSOC);

                $hebergements = array_merge($hotels, $riads, $maisons);
                ?>

                <div class="container-fluid p-4" id="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Hébergements</h3>
                        <a class="btn btn-success" href="dashboard.php?page=hebergements&form=addHebergement">Ajouter un Hébergement</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Ville</th>
                                <th>Type</th>
                                <th>Prix</th>
                                <th>Étoiles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hebergements as $heb): ?>
                                <tr>
                                    <td><?php echo $heb['nom'] ?></td>
                                    <td><?php echo $heb['ville'] ?></td>
                                    <td><?php echo $heb['type'] ?></td>
                                    <td><?php echo number_format($heb['prix'], 2) ?> MAD</td>
                                    <td><?php echo $heb['type'] == 'hotel' ? ($heb['rating'] . ' ⭐') : '-' ?></td>
                                    <td>
                                        <a href="dashboard.php?page=hebergements&form=EditHebergement&type=<?php echo  $heb['type'] ?>&idEditHebergement=<?php echo  $heb['id'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="dashboard.php?page=hebergements&form=deleteHebergement&type=<?php echo  $heb['type'] ?>&id=<?php echo  $heb['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif ?>
            <?php if ($page == 'blogs'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- contenue wastt -->
                <div class="container mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1>
                            <i class="bi bi-journal-text"></i> Manage Blog Posts
                        </h1>
                        <a href="dashboard.php?page=blogs&form=addBlog" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New
                        </a>
                    </div>

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" id="bulkForm">
                        <div class="card mb-4">
                            <div class="card-header bg-light sticky-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <select name="bulk_action" class="form-select me-2" style="width: auto;">
                                            <option value="delete">Delete Selected</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i> Apply
                                        </button>
                                    </div>
                                    <div class="text-muted">
                                        <?= count($blogs) ?> item(s)
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Author</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($blogs)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    No blog posts found. <a href="add.php">Create your first post</a>.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($blogs as $post): ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected[]" value="<?= (int)$post['blog_id'] ?>" class="form-check-input">
                                                    </td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($post['titre']) ?></strong>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($post['image'])): ?>
                                                            <img src="../../backend/admin/uploads/blogs/<?php echo htmlspecialchars($post['image']) ?>"
                                                                alt="<?= htmlspecialchars($post['titre']) ?>"
                                                                class="img-thumbnail">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($post['auteur']) ?></td>
                                                    <td>
                                                        <?= date('M j, Y', strtotime($post['date_blog'])) ?>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="dashboard.php?page=blogs&form=editBlog&id=<?= (int)$post['blog_id'] ?>"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a type="submit" class="btn btn-sm btn-outline-danger" href="dashboard.php?page=blogs&form=deleteBlog&id=<?php echo (int)$post['blog_id'] ?>"
                                                                onclick="return confirm('Are you sure you want to delete this post?')"
                                                                title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (!empty($blogs)): ?>
                                <div class="card-footer bg-light">
                                    <div class="text-muted text-center">
                                        Showing <?= count($blogs) ?> item(s)
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Select all checkboxes
                        const selectAll = document.getElementById('selectAll');
                        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');

                        selectAll.addEventListener('change', function(e) {
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = e.target.checked;
                            });
                        });

                        // Update "Select All" checkbox when individual checkboxes change
                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                if (!this.checked) {
                                    selectAll.checked = false;
                                } else {
                                    // Check if all are now selected
                                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                    selectAll.checked = allChecked;
                                }
                            });
                        });

                        // Bulk form submission confirmation
                        document.getElementById('bulkForm').addEventListener('submit', function(e) {
                            const selected = Array.from(this.querySelectorAll('input[name="selected[]"]:checked'));

                            if (selected.length === 0) {
                                alert('Please select at least one item to perform this action');
                                e.preventDefault();
                                return;
                            }

                            if (!confirm(`Are you sure you want to delete ${selected.length} selected item(s)?`)) {
                                e.preventDefault();
                            }
                        });
                    });
                </script>
            <?php elseif ($page == 'paiments'): ?>
                <!-- NAV FO9 -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Tableau de bord</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-3">
                                <a class="text-dark dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell fs-5'></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">#Liste</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#"
                                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx  bx-user'></i>
                                    <span class="d-none d-md-inline">Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user me-2'></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class='bx bxs-cog me-2'></i>Paramètres</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="../deconnexion/index.php"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <?php
                $stmt = $conn->query("
                    SELECT p.*, CONCAT(u.prenom, ' ', u.nom) AS nom_complet, r.reserv_type 
                    FROM paiements p
                    JOIN reservations r ON p.reservation_id = r.id_reservation
                    JOIN users u ON r.user_id = u.id_user
                    ORDER BY p.id_paiement DESC
                ");
                $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <!-- CONTENUE D PAGE -->
                <div class="container-fluid p-4" id="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Paiements</h3>
                        <a class="btn btn-success" href="dashboard.php?page=paiments&form=addPaiement">
                            <i class="bx bx-plus"></i> Ajouter un Paiement
                        </a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Réservation</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Méthode</th>
                                <th>Statut</th>
                                <th>Date Paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paiements as $paiement): ?>
                                <tr>
                                    <td><?= htmlspecialchars($paiement['reserv_type']) ?></td>
                                    <td><?= htmlspecialchars($paiement['nom_complet']) ?></td>
                                    <td><?= number_format($paiement['montant'], 2) ?> MAD</td>
                                    <td><?= htmlspecialchars($paiement['methode']) ?></td>
                                    <td><?= htmlspecialchars($paiement['statut']) ?></td>
                                    <td><?= htmlspecialchars($paiement['date_paiement']) ?></td>
                                    <td>
                                        <a href="dashboard.php?page=paiments&form=editPaiement&idEditPaiement=<?= $paiement['id_paiement'] ?>" class="btn btn-primary btn-sm">Modifier statut</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>

        <!-- Forms Ajoute-->
        <?php if ($form == 'addVille'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('villeModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="villeModal" tabindex="-1" aria-labelledby="villeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererVille.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="villeModalLabel">Ajouter une Ville</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="villeName" class="form-label">Nom de la ville</label>
                                    <input type="text" class="form-control" id="villeName" name="villeName"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="villeDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="villeDescription" name="villeDescription"
                                        rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="Images" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="Images" name="Images[]" multiple
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="coordonnees" class="form-label">Coordonnées</label>
                                    <input type="text" class="form-control" id="coordonnees" name="coordonnees"
                                        required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter Ville</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'addTour'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('tourModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="tourModal" tabindex="-1" aria-labelledby="tourModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererTours.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tourModalLabel">Ajouter un Tour</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tourName" class="form-label">Nom du Tour</label>
                                    <input type="text" class="form-control" id="tourName" name="tourName"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tourCity" class="form-label">Ville</label>
                                    <select class="form-select" id="tourCity" name="tourCity" required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tourPrice" class="form-label">Prix</label>
                                    <input type="number" class="form-control" id="tourPrice" name="tourPrice"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tourDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="tourDescription" name="tourDescription"
                                        rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tourImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="tourImages" name="tourImages[]"
                                        multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter Tour</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'addHebergement'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('hebergementModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="hebergementModal" tabindex="-1"
                aria-labelledby="hebergementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererHebergement.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hebergementModalLabel">Ajouter un Hébergement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="hebergementName" class="form-label">Nom de l'Hébergement</label>
                                    <input type="text" class="form-control" id="hebergementName"
                                        name="hebergementName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementCity" class="form-label">Ville</label>
                                    <select class="form-select" id="hebergementCity" name="hebergementCity"
                                        required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementType" class="form-label">Type d'Hébergement</label>
                                    <select class="form-select" id="hebergementType" name="hebergementType"
                                        required>
                                        <option value="">Sélectionnez un type</option>
                                        <option value="hotel">Hôtel</option>
                                        <option value="riad">Riad</option>
                                        <option value="maison">Maison</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementRating" class="form-label">Note</label>
                                    <select class="form-select" id="hebergementRating" name="hebergementRating"
                                        required>
                                        <option value="">Sélectionnez une note</option>
                                        <option value="1">1 étoile</option>
                                        <option value="2">2 étoiles</option>
                                        <option value="3">3 étoiles</option>
                                        <option value="4">4 étoiles</option>
                                        <option value="5">5 étoiles</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementPrice" class="form-label">Prix par nuit</label>
                                    <input type="number" class="form-control" id="hebergementPrice"
                                        name="hebergementPrice" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="hebergementDescription"
                                        name="hebergementDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="hebergementImages"
                                        name="hebergementImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter Hébergement</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'addActivitie'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('activitieModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="activitieModal" tabindex="-1"
                aria-labelledby="activitieModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererActivite.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activitieModalLabel">Ajouter une Activité</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="activitieName" class="form-label">Nom de l'Activité</label>
                                    <input type="text" class="form-control" id="activitieName"
                                        name="activitieName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="activitieCity" class="form-label">Ville</label>
                                    <select class="form-select" id="activitieCity" name="activitieCity"
                                        required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="activitiePrice" class="form-label">Prix</label>
                                    <input type="number" class="form-control" id="activitiePrice"
                                        name="activitiePrice" required>
                                </div>

                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="activitieDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="activitieDescription"
                                        name="activitieDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="activitieImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="activitieImages"
                                        name="activitieImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter Activité</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'addEvent'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="eventModal" tabindex="-1"
                aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererEvenement.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel">Ajouter un Événement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="eventName" class="form-label">Nom de l'Événement</label>
                                    <input type="text" class="form-control" id="eventName" name="eventName"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="eventCity" class="form-label">Ville</label>
                                    <select class="form-select" id="eventCity" name="eventCity" required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="eventDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="eventDescription"
                                        name="eventDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="eventImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="eventImages"
                                        name="eventImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter Événement</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'generateReport'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="reportModal" tabindex="-1"
                aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="dashboard.php?action=generateReport" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reportModalLabel">Générer un Rapport</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reportType" class="form-label">Type de Rapport</label>
                                    <select class="form-select" id="reportType" name="reportType" required>
                                        <option value="">Sélectionnez un type</option>
                                        <option value="reservations">Réservations</option>
                                        <option value="clients">Clients</option>
                                        <option value="revenus">Revenus</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="reportDateRange" class="form-label">Période</label>
                                    <input type="text" class="form-control" id="reportDateRange"
                                        name="reportDateRange" placeholder="Ex: 01/01/2023 - 31/12/2023" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Générer Rapport</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($form == 'addPaiement'): ?>
            <?php
            // Récupère les réservations pour choix
            $stmt = $conn->query("
    SELECT r.id_reservation, r.reserv_type, CONCAT(u.prenom, ' ', u.nom) AS client
    FROM reservations r
    JOIN users u ON r.user_id = u.id_user
    ORDER BY r.id_reservation DESC
");
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('addPaiementModal'));
                    myModal.show();
                };
            </script>

            <div class="modal fade" id="addPaiementModal" tabindex="-1" aria-labelledby="addPaiementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererPaiement.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPaiementModalLabel">Ajouter un Paiement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reservation" class="form-label">Réservation</label>
                                    <select name="reservationId" class="form-select" required>
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($reservations as $r): ?>
                                            <option value="<?= $r['id_reservation'] ?>">
                                                <?= $r['reserv_type'] ?> - <?= $r['client'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="montant" class="form-label">Montant</label>
                                    <input type="number" step="0.01" name="montant" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="methode" class="form-label">Méthode</label>
                                    <input type="text" name="methode" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select name="statut" class="form-select" required>
                                        <option value="en attente">En attente</option>
                                        <option value="réussi">Réussi</option>
                                        <option value="échoué">Échoué</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date de paiement</label>
                                    <input type="date" name="datePaiement" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="addPaiement" class="btn btn-primary">Ajouter</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>


        <!-- ########################################" -->







        <!-- Forms Modifier -->
        <?php if ($form == 'EditVille'): ?>
            <?php
            if ($_GET['idEditVille']) {
                $idEditVille = $_GET['idEditVille'];
                $stmt = $conn->prepare("SELECT * FROM villes WHERE ville_id = :id");
                $stmt->execute([':id' => $idEditVille]);
                $cityToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($cityToEdit) {
                    $nomVille = $cityToEdit['nom'];
                    $descrVille = $cityToEdit['ville_description'];
                    $corddonnesVille = $cityToEdit['coordonnees'];
                }
            } else {
                $nomVille = "";
                $descrVille = "";
                $corddonnesVille = "";
            } ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('villeModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="villeModal" tabindex="-1" aria-labelledby="villeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererVille.php?EditVille&idEditVille=<?php echo $idEditVille ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="villeModalLabel">Modifier une Ville</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="villeName" class="form-label">Nom de la ville</label>
                                    <input type="text" class="form-control" id="villeName" name="villeName"
                                        required value=<?php echo $nomVille ?>>
                                </div>
                                <div class="mb-3">
                                    <label for="villeDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="villeDescription" name="villeDescription"
                                        rows="3" required><?php echo $descrVille ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="Images" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="Images" name="Images[]" multiple
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="coordonnees" class="form-label">Coordonnées</label>
                                    <input type="text" class="form-control" id="coordonnees" name="coordonnees"
                                        required value=<?php echo "'$corddonnesVille'" ?>>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier Ville</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($form == 'editReservation'): ?>
            <?php
            $idEdit = $_GET['idEditReservation'];
            $stmt = $conn->prepare("SELECT * FROM reservations WHERE id_reservation = ?");
            $stmt->execute([$idEdit]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            $users = $conn->query("SELECT id_user, nom, prenom FROM users")->fetchAll(PDO::FETCH_ASSOC);
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
                        <form action="../../backend/admin/pages/gererReservation.php?editReservation=1&idEditReservation=<?php echo $reservation['id_reservation'] ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reservationModalLabel">Modifier la Réservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reservType" class="form-label">Type de réservation</label>
                                    <input type="text" class="form-control" name="reservType" value="<?= $reservation['reserv_type'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="userId" class="form-label">Utilisateur</label>
                                    <select class="form-select" name="userId" required>
                                        <option value="">Sélectionner un utilisateur</option>
                                        <?php foreach ($users as $user): ?>
                                            <?php $selected = $user['id_user'] == $reservation['user_id'] ? 'selected' : ''; ?>
                                            <option value="<?= $user['id_user'] ?>" <?= $selected ?>>
                                                <?= $user['prenom'] . ' ' . $user['nom'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date début</label>
                                    <input type="date" class="form-control" name="dateDebut" value="<?= $reservation['date_debut'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date fin</label>
                                    <input type="date" class="form-control" name="dateFin" value="<?= $reservation['date_fin'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select class="form-select" name="statut" required>
                                        <option value="confirmée" <?= $reservation['statut'] == 'confirmée' ? 'selected' : '' ?>>Confirmée</option>
                                        <option value="en attente" <?= $reservation['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                        <option value="annulée" <?= $reservation['statut'] == 'annulée' ? 'selected' : '' ?>>Annulée</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updateReservation" class="btn btn-primary">Mettre à jour</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($form == 'EditActivitie'): ?>
            <?php
            if ($_GET['idEditActivitie']) {
                $idEditActivitie = $_GET['idEditActivitie'];
                $stmt = $conn->prepare("SELECT * FROM activites WHERE activite_id = :id");
                $stmt->execute([':id' => $idEditActivitie]);
                $activitieToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($activitieToEdit) {
                    $activitieName = $activitieToEdit['titre'];
                    $activitieCity = $activitieToEdit['ville_id'];
                    $activitiePrice = $activitieToEdit['prix'];
                    $dateDebut = $activitieToEdit['dateDebut'];
                    $dateFin = $activitieToEdit['dateFin'];
                    $activitieDescription = $activitieToEdit['activite_description'];
                }
            } else {
                $activitieName = "";
                $activitieCity = "";
                $activitiePrice = "";
                $dateDebut = "";
                $dateFin = "";
                $activitieDescription = "";
            } ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('activitieModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="activitieModal" tabindex="-1"
                aria-labelledby="activitieModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererActivite.php?EditActivitie&idEditActivitie=<?php echo $idEditActivitie ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activitieModalLabel">Modifier une Activité</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="activitieName" class="form-label">Nom de l'Activité</label>
                                    <input type="text" class="form-control" id="activitieName"
                                        name="activitieName" required value="<?php echo $activitieName; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="activitieCity" class="form-label">Ville</label>
                                    <select class="form-select" id="activitieCity" name="activitieCity"
                                        required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            if ($city['ville_id'] == $activitieCity) {
                                                echo "<option value='{$city['ville_id']}' selected>{$city['nom']}</option>";
                                            } else {
                                                echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="activitiePrice" class="form-label">Prix</label>
                                    <input type="number" class="form-control" id="activitiePrice"
                                        name="activitiePrice" required value="<?php echo $activitiePrice; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required value="<?php echo $dateDebut; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required value="<?php echo $dateFin; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="activitieDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="activitieDescription"
                                        name="activitieDescription" rows="3" required><?php echo  $activitieDescription ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="activitieImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="activitieImages"
                                        name="activitieImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier Activité</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($form == 'EditTours'): ?>
            <?php
            if ($_GET['idEditTours']) {
                $idEditTour = $_GET['idEditTours'];
                $stmt = $conn->prepare("SELECT * FROM tours WHERE tour_id = :id");
                $stmt->execute([':id' => $idEditTour]);
                $TourToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($TourToEdit) {
                    $TourName = $TourToEdit['titre'];
                    $TourCity = $TourToEdit['ville_id'];
                    $TourPrice = $TourToEdit['prix'];
                    $dateDebut = $TourToEdit['dateDebut'];
                    $dateFin = $TourToEdit['dateFin'];
                    $TourDescription = $TourToEdit['tour_description'];
                }
            } else {
                $TourName = "";
                $TourCity = "";
                $TourPrice = "";
                $dateDebut = "";
                $dateFin = "";
                $TourDescription = "";
            } ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('TourModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="TourModal" tabindex="-1"
                aria-labelledby="TourModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererTours.php?EditTour&idEditTour=<?php echo $idEditTour ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TourModalLabel">Modifier une Tour</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="TourName" class="form-label">Nom de Tour</label>
                                    <input type="text" class="form-control" id="TourName"
                                        name="tourName" required value="<?php echo $TourName; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tourCity" class="form-label">Ville</label>
                                    <select class="form-select" id="tourCity" name="tourCity"
                                        required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            if ($city['ville_id'] == $TourCity) {
                                                echo "<option value='{$city['ville_id']}' selected>{$city['nom']}</option>";
                                            } else {
                                                echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="TourPrice" class="form-label">Prix</label>
                                    <input type="number" class="form-control" id="TourPrice"
                                        name="tourPrice" required value="<?php echo $TourPrice; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required value="<?php echo $dateDebut; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required value="<?php echo $dateFin; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="TourDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="TourDescription"
                                        name="tourDescription" rows="3" required><?php echo  $TourDescription ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="TourImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="TourImages"
                                        name="tourImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier Tour</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($form == 'Editevenement'): ?>
            <?php
            if ($_GET['idEditevenement']) {
                $idEditEvent = $_GET['idEditevenement'];
                $stmt = $conn->prepare("SELECT * FROM evenements WHERE id_evenement = :id");
                $stmt->execute([':id' => $idEditEvent]);
                $EventToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($EventToEdit) {
                    $EventName = $EventToEdit['nom'];
                    $EventCity = $EventToEdit['lieu'];
                    $dateDebut = $EventToEdit['dateDebut'];
                    $dateFin = $EventToEdit['dateFin'];
                    $EventDescription = $EventToEdit['description_evenement'];
                }
            } else {
                $EventName = "";
                $EventCity = "";
                $EventPrice = "";
                $dateDebut = "";
                $dateFin = "";
                $EventDescription = "";
            } ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('EventModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="EventModal" tabindex="-1"
                aria-labelledby="EventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererEvenement.php?EditEvent&idEditEvent=<?php echo $idEditEvent ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="EventModalLabel">Modifier une evenement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="EventName" class="form-label">Nom de l'evenement</label>
                                    <input type="text" class="form-control" id="EventName"
                                        name="eventName" required value="<?php echo $EventName; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="EventCity" class="form-label">Ville</label>
                                    <select class="form-select" id="EventCity" name="eventCity"
                                        required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            if ($city['ville_id'] == $EventCity) {
                                                echo "<option value='{$city['ville_id']}' selected>{$city['nom']}</option>";
                                            } else {
                                                echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="dateDebut" class="form-label">Date debut</label>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut"
                                        required value="<?php echo $dateDebut; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="dateFin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin"
                                        required value="<?php echo $dateFin; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="EventDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="EventDescription"
                                        name="eventDescription" rows="3" required><?php echo  $EventDescription ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="EventImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="EventImages"
                                        name="eventImages[]" multiple required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier l'evenement</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($form == 'EditHebergement'): ?>
            <?php
            $id = $_GET['idEditHebergement'];
            $type = $_GET['type'];
            switch ($type) {
                case 'hotel':
                    $stmt = $conn->prepare("SELECT * FROM hotel WHERE id = :id");
                    break;
                case 'riad':
                    $stmt = $conn->prepare("SELECT * FROM riads WHERE id = :id");
                    break;
                case 'maison':
                    $stmt = $conn->prepare("SELECT * FROM maison WHERE id = :id");
                    break;
            }

            $stmt->execute([':id' => $id]);
            $heb = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT * FROM hebergements WHERE type = :type and hebergement_id = :id");
            $stmt->execute([':type' => $type, ':id' => $id]);
            $hebergementALL = $stmt->fetch(PDO::FETCH_ASSOC);


            $stmt = $conn->prepare("SELECT * FROM detail_hebergements where id_hebergement = :id");
            $stmt->execute([':id' => $hebergementALL["id"]]);
            $hebergementDetails = $stmt->fetch(PDO::FETCH_ASSOC);
            $hebergementDescription = $hebergementDetails["detail"];

            $nom = $heb['nom'];
            $prix = $heb['prix'];
            if ($type == 'hotel') {
                $rating = $heb['etoiles'];
            } else {
                $rating = null;
            }
            $ville_id = $heb['ville_id'];
            ?>

            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('hebergementModal'));
                    myModal.show();
                };
            </script>

            <div class="modal fade" id="hebergementModal" tabindex="-1" aria-labelledby="hebergementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererHebergement.php?EditHebergement&type=<?php echo $type ?>&idEditHebergement=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hebergementModalLabel">Modifier un Hébergement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="hebergementName" class="form-label">Nom de l'Hébergement</label>
                                    <input type="text" class="form-control" id="hebergementName" name="hebergementName" value="<?= $nom ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementCity" class="form-label">Ville</label>
                                    <select class="form-select" id="hebergementCity" name="hebergementCity" required>
                                        <option value="">Sélectionnez une ville</option>
                                        <?php
                                        foreach ($cities as $city) {
                                            if ($city['ville_id'] == $ville_id) {
                                                echo "<option value='{$city['ville_id']}' selected>{$city['nom']}</option>";
                                            } else {
                                                echo "<option value='{$city['ville_id']}'>{$city['nom']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if ($type == 'hotel'): ?>
                                    <div class="mb-3">
                                        <label for="hebergementRating" class="form-label">Note</label>
                                        <select class="form-select" id="hebergementRating" name="hebergementRating" required>
                                            <option value="">Sélectionnez une note</option>
                                            <?php for ($i = 1; $i <= 5; $i++) {
                                                if ($rating == $i) {
                                                    echo "<option value='$i' selected>$i étoile</option>";
                                                } else {
                                                    echo "<option value='$i' >$i étoile</option>";
                                                }
                                            } ?>

                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="hebergementPrice" class="form-label">Prix par nuit</label>
                                    <input type="number" class="form-control" id="hebergementPrice" name="hebergementPrice"
                                        value="<?php echo $prix ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="hebergementDescription" name="hebergementDescription"
                                        required><?php echo $hebergementDescription ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementImages" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="hebergementImages" name="hebergementImages[]" multiple>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier Hébergement</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        <?php endif; ?>
        <div class="alert-hkk">
            <?php if (isset($_GET['success'])) {
                $success = $_GET['success'];
                echo "<p class='alert alert-success alertFo9'>$success</p>";
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

        <?php if ($form == 'editPaiement'): ?>
            <?php
            $idEdit = $_GET['idEditPaiement'];
            $stmt = $conn->prepare("SELECT * FROM paiements WHERE id_paiement = ?");
            $stmt->execute([$idEdit]);
            $paiement = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('paiementModal'));
                    myModal.show();
                };
            </script>

            <div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererPaiement.php?editPaiement&idEditPaiement=<?= $paiement['id_paiement'] ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paiementModalLabel">Modifier le Statut du Paiement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select class="form-select" name="statut" required>
                                        <option value="en attente" <?= $paiement['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                        <option value="réussi" <?= $paiement['statut'] == 'réussi' ? 'selected' : '' ?>>Réussi</option>
                                        <option value="échoué" <?= $paiement['statut'] == 'échoué' ? 'selected' : '' ?>>Échoué</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updatePaiement" class="btn btn-primary">Mettre à jour</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif ?>


        <?php if ($form == 'addBlog'): ?>
            <script>
                window.onload = function() {
                    var modal = new bootstrap.Modal(document.getElementById('blogModal'));
                    modal.show();
                };
            </script>

            <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/blogs/add.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="blogModalLabel">Ajouter un Article</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="auteur" class="form-label">Auteur</label>
                                    <input type="text" class="form-control" id="auteur" name="auteur" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date_blog" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date_blog" name="date_blog" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contenu" class="form-label">Contenu</label>
                                    <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="addBlog" class="btn btn-primary">Publier</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif ?>

        <?php if ($form == 'editBlog'): ?>
            <?php
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM articles WHERE blog_id = ?");
            $stmt->execute([$id]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <script>
                window.onload = function() {
                    var modal = new bootstrap.Modal(document.getElementById('editBlogModal'));
                    modal.show();
                };
            </script>

            <div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/blogs/edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBlogModalLabel">Modifier l’Article</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Titre</label>
                                    <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($blog['titre']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Auteur</label>
                                    <input type="text" name="auteur" class="form-control" value="<?= htmlspecialchars($blog['auteur']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date_blog" class="form-control" value="<?= $blog['date_blog'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contenu</label>
                                    <textarea name="contenu" rows="5" class="form-control"><?= htmlspecialchars($blog['contenu']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <?php if (!empty($blog['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../../backend/admin/uploads/blogs/<?= $blog['image'] ?>" class="img-thumbnail" width="120">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updateBlog" class="btn btn-primary">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif ?>

        <?php if ($form == 'addUser'): ?>
            <script>
                window.onload = function() {
                    var myModal = new bootstrap.Modal(document.getElementById('UserModal'));
                    myModal.show();
                };
            </script>
            <div class="modal fade" id="UserModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererUsers.php?AddUser" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="UserModalLabel">Ajouter un utilisateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $nom = $prenom = $email = $telephone = $pays = $ville = $adresse = $user_role = "";
                                ?>
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pays" class="form-label">Pays</label>
                                    <input type="text" class="form-control" id="pays" name="pays" required>
                                </div>
                                <div class="mb-3">
                                    <label for="ville" class="form-label">Ville</label>
                                    <input type="text" class="form-control" id="ville" name="ville" required>
                                </div>
                                <div class="mb-3">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                                </div>
                                <div class="mb-3">
                                    <label for="user_role" class="form-label">Rôle</label>
                                    <select class="form-select" id="user_role" name="user_role">
                                        <option value="user">Utilisateur</option>
                                        <option value="admin">Administrateur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if ($form == 'editUser'): ?>
            <?php
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <script>
                window.onload = function() {
                    var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    modal.show();
                };
            </script>

            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form action="../../backend/admin/pages/gererUsers.php?EditUser&id=<?php echo $id; ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pays</label>
                                    <input type="text" name="pays" class="form-control" value="<?= htmlspecialchars($user['pays']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ville</label>
                                    <input type="text" name="ville" class="form-control" value="<?= htmlspecialchars($user['ville']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Adresse</label>
                                    <input type="text" name="adresse" class="form-control" value="<?= htmlspecialchars($user['adresse']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rôle</label>
                                    <select name="user_role" class="form-select">
                                        <option value="user" <?= $user['user_role'] == 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                        <option value="admin" <?= $user['user_role'] == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updateUser" class="btn btn-primary">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="script.js"></script>
</body>

</html>