<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TouraMaroc</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../../generalCSS/bootstrap.min.css" />
  <link rel="stylesheet" href="../../generalCSS/style.css" />
  <style>
    .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
    }
  </style>
</head>

<header>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a style="color: #0d6efd; font-size: 35px; font-weight: bold;"
       class="navbar-brand me-auto" href="../accueil/index.php">TouraMaroc</a>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul id="navbar-nav" class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="../accueil/index.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../hebergement/index.php">Hébergement</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../toursactivities/index.php">Tours & Activities</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../evenement/index.php">Evénement</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../transport/index.php">Transport</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../blog/index.php">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../contact/index.php">Contact</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="d-flex me-0">
        <select name="lang" id="lang" class="form-select me-1">
          <option value="fr">Français</option>
          <option value="ar">العربية</option>
          <option value="en">English</option>
        </select>
        <a href="/Connexion.html" class="btn btn-primary">Connexion</a>
      </div>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Active link toggle effect
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
  });
</script>

