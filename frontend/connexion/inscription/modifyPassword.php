<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TouraMaroc Auth</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../generalCSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<div class="container auth-main-container">
  

  <!-- modify Password Card -->
  <div class="auth-card auth-card-active" id="modifyPwd">
    <div class="auth-card-content">
      <h3 class="text-center">Réinitialiser votre mot de passe</h3>

      <form id="forgotForm" action="php/modofyPswInDB.php"  method="post">
           <div class="form-group auth-input-group">
          <div class="auth-password-wrapper">
            <input type="password" name="password" class="form-control auth-input-field" placeholder="Mot de passe" id="signupPassword"
              required />
            <button type="button" class="auth-password-toggle-btn" onclick="togglePassword('signupPassword', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="form-group auth-input-group">
          <div class="auth-password-wrapper">
            <input type="password" class="form-control auth-input-field" placeholder="Confirmer le mot de passe"
              id="confirmPassword" name="confirmPassword" required />
            <button type="button" class="auth-password-toggle-btn" onclick="togglePassword('confirmPassword', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block auth-submit-btn">
          modifier
        </button>
        <p class="mt-3 text-center">
          <a href="../index.php" onclick="showCard('login')"><i class="fas fa-arrow-left mr-2"></i>Retour à la connexion</a>
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
<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['message'])): ?>
  <script>
    alert(<?php echo json_encode($_GET['message']); ?>);
  </script>
<?php 
// sleep(1);
// if ($_GET['message'] === "Votre mot de passe a été réinitialisé avec succès"){
//     header("Location: ../index.html");
// }
endif; ?>
<script src="javascript/createAccountPart1.js"></script>

</div>