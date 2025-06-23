<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TouraMaroc Auth</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../generalCSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<div class="container auth-main-container inscriptionCard">



    <!-- confirm email Card -->
<div class="auth-card auth-card-active" id="ConfirmEmail">
  <div class="auth-card-content">
    <h3 class="text-center">Vérifiez votre email</h3>
    
    <p class="text-center text-muted">Entrez votre email pour recevoir un code</p>
    <form id="confirmEmail" action='SendEmailTM.php' method='post'>
      <div class="form-group auth-input-group">
        <input type="email" name="email" id="email" class="form-control auth-input-field" value="<?php  session_start(); echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>"  placeholder="votre@email.com"  required />
      </div>
       <?php if (isset($_COOKIE["Code"])):?>
        <p class='text center' id='delai'>Entree votre code apree 60</p>
      <div class="form-group auth-input-group">
        <!-- <label for="verificationCode">Code de vérification</label> -->
      <input type="number" name="verificationCode" id="verificationCode"
            class="form-control auth-input-field" placeholder="XXXX"
            style="display: block;" />
      </div>

        <?php endif ;?>
<?php if (!isset($_COOKIE["Code"])):?>
      <button type="submit" id='Envoyer' class="btn btn-primary btn-block auth-submit-btn">
        <!-- <i class="fas fa-paper-plane mr-2"> -->
        </i>Envoyer le code
      </button>
<?php endif ;?>
      <p class="mt-3 text-center">
        <a href="../index.php" onclick="showCard('login')"><i class="fas fa-arrow-left mr-2"></i>Retour à la connexion</a>
      </p>

      
    </form>
  </div>
</div>

<div class="auth-card " id="verifyCard">

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
<?php endif; ?>




  <script src="javascript/createAccountP3.js"></script>
</div>