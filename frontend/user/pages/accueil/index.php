<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TouraMaroc</title>
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
</head>

<div>
    <?php include '../../components/nav.php' ?>

    <section id="hero" class="heroAccueil section dark-background">
        <img src="../../media/images/heroImage.png" alt="Hero" />
        <div class="container d-flex flex-column align-items-center justify-content-center text-center"
            data-aos="fade-up" data-aos-delay="100">
            <h2 style="color: white;">Bienvenue à TouraMaroc</h2>
            <p>
            <p style="text-align: center;">
                <span style="color: rgb(255, 255, 255);" class="typed typed-white" id="typed-text"></span>
            </p>
            </p>
        </div>
    </section>
    <?php include '../../components/footer.php' ?>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Typed("#typed-text", {
                strings: ["Tours marocains", "Réservation d'hôtels", "Activités au Maroc", "Événements au Maroc"],
                typeSpeed: 50,
                backSpeed: 25,
                backDelay: 2000,
                loop: true
            });
        });
    </script>

</div>