
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
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class='bx bx-log-out me-2'></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
</nav>
<!-- Users table -->
<div class="container-fluid p-4">
    <?php
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>List of Users</h3>
        <a class="btn btn-success" href="dashboard.php?form=addUser">
            <i class="bi bi-plus-circle"></i> Add User
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom Complet</th>
                <th>Email</th>
                <th>telephone</th>
                <th>pays</th>
                <th>adresse</th>
                <th>user_role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['nom']) . htmlspecialchars($user['prenom']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['telephone']) ?></td>
                    <td><?= htmlspecialchars($user['pays']) ?></td>
                    <td><?= htmlspecialchars($user['adresse']) ?></td>
                    <td><?= htmlspecialchars($user['user_role']) ?></td>
                    <td class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="editUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['first_name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>', '<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>')">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['first_name'], ENT_QUOTES) ?>')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>