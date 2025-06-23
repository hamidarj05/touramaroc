<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouraMaroc</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
</head>
<div>
    <?php include '../../components/nav.php' ?>

    <div class="container container-Contact ">
        <div class="card">
            <h3 class="h3 text-center">Nous contacter</h3>
            <p class="text-center text-muted">Remplissez le formulaire pour toute question sur votre voyage au Maroc</p>

            <form id="contactForm" action="../../../../backend/admin/pages/gererMessages.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom complet" required />
                    <span class="floating-label">Nom complet</span>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Adresse e-mail" required />
                    <span class="floating-label">Adresse e-mail</span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet de votre message" required />
                    <span class="floating-label">Sujet</span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Décrivez votre demande..." required></textarea>
                    <span class="floating-label">Votre message</span>
                </div>
                <button type="submit" class="btn btn-primary btn-envoyer btn-block">
                    <i class="fas fa-paper-plane mr-2"></i>Envoyer le message
                </button>

                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Message envoyé!</h4>
                    <p>Nous avons bien reçu votre demande et vous répondrons dans les plus brefs délais.</p>
                </div>
            </form>
        </div>

        <div class="text-container">
            <h2>Planifiez votre voyage au Maroc</h2>
            <p>Notre équipe d'experts en TouraMaroc est à votre disposition pour créer l'expérience de voyage parfaite. Que vous rêviez de médinas animées, de déserts majestueux ou de côtes ensoleillées, nous sommes là pour concrétiser votre projet.</p>
            <p>Nous répondons à toutes vos questions sur les hébergements, les transports, les activités et les expériences authentiques qui rendront votre séjour inoubliable.</p>

            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">+212 6 00 00 00 00</div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">contact@TouraMaroc.com</div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">Avenue Mohammed V, Marrakech</div>
                </div>
            </div>

            <p class="mt-4"><strong>Marhba bik !</strong> - Bienvenue au Maroc, terre d'hospitalité.</p>
        </div>
    </div>
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
    <?php include '../../components/footer.php' ?>

</div>