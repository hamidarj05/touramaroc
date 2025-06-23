<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TouraMaroc Auth</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../generalCSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<div class="container auth-main-container inscriptionCard">
  <!-- Login Card -->
  <div class="auth-card auth-card-active" id="loginCard">
    <div class="auth-card-content">
      <h3 class="text-center">Connexion</h3>
      <p class="text-center text-muted">Entrez vos informations pour continuer</p>


<form id="signupForm" method="post" action="php/createAccountPart1.php">
  <div class="form-group auth-input-group">
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" class="form-control auth-input-field" placeholder="Votre nom" required />
  </div>

  <div class="form-group auth-input-group">
    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" class="form-control auth-input-field" placeholder="Votre prénom" required />
  </div>

  <div class="form-group auth-input-group">
    <label for="telephone">Téléphone</label>
    <input type="tel" id="telephone" name="telephone" class="form-control auth-input-field" placeholder="Votre téléphone" required />
  </div>

    <div class="form-group">
      <label for="pays">Pays</label>
      <select id="pays" name="pays" class="form-control" required>
        <option value="" selected disabled>-- Sélectionnez un pays --</option>
      </select>
    </div>

  <div class="form-group auth-input-group">
    <label for="ville">Ville</label>
    <select id="ville" name="ville" class="form-control" required>
      <option value="" selected disabled>-- Choisir une ville --</option>
    </select>
  </div>

  <div class="form-group auth-input-group">
    <label for="adresse">Adresse</label>
    <input type="text" id="adresse" name="adresse" class="form-control auth-input-field" placeholder="Votre adresse" required />
  </div>

  <button type="submit" class="btn btn-primary btn-block auth-submit-btn">
    <i class="fas fa-user-plus mr-2"></i>S'inscrire
  </button>

  <p class="mt-3 text-center">
    Vous avez déjà un compte ? <a href="../index.php" onclick="showCard('login')">Se connecter</a>
  </p>
</form>
    </div>
  </div>



    <!-- Info Panel -->
  <div class="auth-info-panel">
    <h2>Rejoignez TouraMaroc</h2>
    <p class="auth-lead-text">
      Découvrez les merveilles du Maroc, des médinas animées aux paysages désertiques époustouflants.
    </p>
    <div class="auth-benefits-grid">
      <div class="auth-benefit-item">
        <div class="auth-benefit-icon"><i class="fas fa-route"></i></div>
        <h4>Itinéraires uniques</h4>
        <p>Accès à des expériences hors des sentiers battus</p>
      </div>
      <div class="auth-benefit-item">
        <div class="auth-benefit-icon"><i class="fas fa-tag"></i></div>
        <h4>Avantages membres</h4>
        <p>Réductions exclusives sur vos voyages</p>
      </div>
      <div class="auth-benefit-item">
        <div class="auth-benefit-icon"><i class="fas fa-heart"></i></div>
        <h4>Vos favoris</h4>
        <p>Enregistrez vos lieux préférés</p>
      </div>
      <div class="auth-benefit-item">
        <div class="auth-benefit-icon"><i class="fas fa-clock"></i></div>
        <h4>Gain de temps</h4>
        <p>Réservations rapides et sécurisées</p>
      </div>
    </div>
    <p class="auth-welcome-text"><b>Marhba bik !</b> Bienvenue chez les amoureux du Maroc.</p>
  </div>
  <script src="javascript/createAccountPart1.js"></script>

</div>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    echo "<script>alert('$message');</script>";
}

?>