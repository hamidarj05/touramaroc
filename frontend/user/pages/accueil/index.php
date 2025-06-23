<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TouraMaroc</title>
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style>
        .villes {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 90px;
            margin-top: 40px;
        }

        .ville-card {
            width: 2à0px;
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }

        .ville-card:hover {
            transform: scale(1.03);
        }

        .ville-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .ville-info {
            padding: 15px;
        }

        .ville-info h4 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .ville-info p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .btn-voir {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .btn-voir:hover {
            background-color: #e0a800;
        }
    </style>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

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
    <div class="main">
        <div class="villes">
            <?php include 'afficheVilles.php' ?>
        </div>

        <div class="activitiesTours">
            <?php include 'afficherTourActivities.php' ?>
        </div>

        <div class="aficherEvents">
            <?php include 'afficherEvents.php' ?>
        </div>

        <div class="afficherHebergement">
            <?php include 'afficherHebergement.php' ?>
        </div>
    </div>











    <?php include '../../components/footer.php' ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script>
        VanillaTilt.init(document.querySelectorAll(".card-container"));
    </script>

    <script>
        VanillaTilt.init(document.querySelectorAll(".card-container"), {
            max: 10,
            speed: 500,
            glare: true,
            "max-glare": 0.1,
            scale: 1.03
        });
    </script>

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