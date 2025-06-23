<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouraMaroc</title>
    <link href="frontend/generalCSS/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="frontend/connexion/index.html">
                TouraMaroc
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="frontend/connexion/index.html">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activities">Activities</a></li>
                    <li class="nav-item"><a class="nav-link" href="#offers">Offers</a></li>
                </ul>

                <!-- Booking/Sign-in Buttons -->
                <div class="d-flex">
                    <a href="frontend/connexion/index.html" class="btn btn-booking ms-3">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span class="d-none d-sm-inline">Booking</span>
                    </a>

                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-slideshow">
        <!-- Slide 1 (Marrakech) -->
        <div class="hero-slide active" style="background-image: url('assets/images/MarrakeshHero.jpg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-text text-center w-100">
                    <h1>Découvrez Marrakech</h1>
                    <p class="lead">Les souks animés et les palais de la Ville Rouge vous attendent</p>
                    <a href="frontend/connexion/index.html" class="btn btn-primary btn-lg">Explorer Maintenant</a>
                </div>
            </div>
        </div>


        <!-- Slide 2 (Chefchaouen) -->
        <div class="hero-slide" style="background-image: url('assets/images/ChefchaouenHero.jpg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-text text-center w-100">
                    <h1>Flânez à Chefchaouen</h1>
                    <p class="lead">Perdez-vous dans les ruelles de la Perle Bleue</p>
                    <a href="frontend/connexion/index.html" class="btn btn-primary btn-lg">Explorer Maintenant</a>
                </div>
            </div>
        </div>


        <!-- Slide 3 (Sahara) -->
        <div class="hero-slide" style="background-image: url('assets/images/SaharaHero.jpg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-text text-center w-100">
                    <h1>Parcourez le Sahara</h1>
                    <p class="lead">Dunes dorées et ciels étoilés à l'infini</p>
                    <a href="frontend/connexion/index.html" class="btn btn-primary btn-lg">Explorer Maintenant</a>
                </div>
            </div>
        </div>

    </section>

    <!-- Destinations Carousel -->
    <section id="destinations" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--majorelle-blue);">Explorez le Maroc</h2>

            <div class="destinations-carousel-wrapper">
                <div class="destinations-carousel" id="destinations-carousel">

                    <!-- Marrakech -->
                    <div class="destination-card">
                        <img src="assets/images/Marrakech.jpg" alt="Marrakech">
                        <div class="card-body">
                            <h5>Marrakech</h5>
                            <p>Ville animée au cœur de la tradition marocaine.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Chefchaouen -->
                    <div class="destination-card">
                        <img src="assets/images/Chefchaouen.jpg" alt="Chefchaouen">
                        <div class="card-body">
                            <h5>Chefchaouen</h5>
                            <p>Ville bleue paisible nichée dans les montagnes.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Merzouga -->
                    <div class="destination-card">
                        <img src="assets/images/Merzouga.jpg" alt="Merzouga">
                        <div class="card-body">
                            <h5>Merzouga</h5>
                            <p>Village désertique célèbre pour ses dunes dorées.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Essaouira -->
                    <div class="destination-card">
                        <img src="assets/images/Essaouira.jpeg" alt="Essaouira">
                        <div class="card-body">
                            <h5>Essaouira</h5>
                            <p>Une ville côtière alliant air marin et art</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Rabat -->
                    <div class="destination-card">
                        <img src="assets/images/Rabat.jpg" alt="Rabat">
                        <div class="card-body">
                            <h5>Rabat</h5>
                            <p>Capitale moderne à l’histoire riche.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Tanger -->
                    <div class="destination-card">
                        <img src="assets/images/Tanger.jpg" alt="Tanger">
                        <div class="card-body">
                            <h5>Tanger</h5>
                            <p>Rencontre entre l'Atlantique et la Méditerranée.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Casablanca -->
                    <div class="destination-card">
                        <img src="assets/images/CasaBlanca.jpg" alt="Casablanca">
                        <div class="card-body">
                            <h5>Casablanca</h5>
                            <p>Centre économique au style urbain et moderne.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Agadir -->
                    <div class="destination-card">
                        <img src="assets/images/Agadir.jpg" alt="Agadir">
                        <div class="card-body">
                            <h5>Agadir</h5>
                            <p>Une station balnéaire ensoleillée prisée pour son climat doux.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                    <!-- Fes -->
                    <div class="destination-card">
                        <img src="assets/images/Fes.jpg" alt="Fès">
                        <div class="card-body">
                            <h5>Fès</h5>
                            <p>Ville spirituelle au patrimoine millénaire.</p>
                            <a href="frontend/connexion/index.html" class="btn btn-sm"
                                style="background-color: var(--zellige-turquoise); color: white;">Voir les circuits</a>
                        </div>
                    </div>

                </div>
            </div>
            <div id="destinations-dots" class="carousel-dots mt-4 text-center"></div>
        </div>
    </section>


    <!-- ======= ACTIVITÉS SECTION ======= -->
    <section id="activities" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--majorelle-blue);">Expériences Marocaines</h2>

            <!-- Catégories -->
            <div class="activity-categories mb-4 text-center">
                <button class="category-btn active" data-category="all">Tout</button>
                <button class="category-btn" data-category="desert">Désert</button>
                <button class="category-btn" data-category="cultural">Culturel</button>
                <button class="category-btn" data-category="coastal">Côtier</button>
            </div>

            <!-- Activités -->
            <div class="activities-carousel-wrapper">
                <div class="activities-carousel" id="activities-carousel">
                    <!-- Rabat Medina Walk -->
                    <div class="activity-card" data-category="cultural">
                        <img src="assets/images/RabatMedina.jpg" alt="Rabat medina">
                        <div class="card-body">
                            <span class="activity-badge"
                                style="background-color: var(--zellige-turquoise);">Culturel</span>
                            <h5>Balade dans la Médina</h5>
                            <p>Découvrez les ruelles de la médina de Rabat</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 3 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Rabat</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--zellige-turquoise); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Casablanca Hassan II -->
                    <div class="activity-card" data-category="cultural">
                        <img src="assets/images/Casablanca.jpg" alt="Mosquée Hassan II">
                        <div class="card-body">
                            <span class="activity-badge"
                                style="background-color: var(--zellige-turquoise);">Culturel</span>
                            <h5>Visitez la Mosquée Hassan II</h5>
                            <p>Découvrez la grande mosquée du Maroc</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 1 Heure</span>
                                <span><i class="fas fa-map-marker-alt"></i> Casablanca</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--zellige-turquoise); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Ouarzazate Studios -->
                    <div class="activity-card" data-category="desert">
                        <img src="assets/images/OuarzazateStudios.jpg" alt="Ouarzazate studios">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--spice-orange);">Désert</span>
                            <h5>Studios de Cinéma</h5>
                            <p>Découvrez les studios célèbres du cinéma</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 2 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Ouarzazate</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--spice-orange); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Tangier Medina Tour -->
                    <div class="activity-card" data-category="cultural">
                        <img src="assets/images/TangierMedina.jpeg" alt="Tangier medina">
                        <div class="card-body">
                            <span class="activity-badge"
                                style="background-color: var(--zellige-turquoise);">Cultural</span>
                            <h5>Visite de la Médina</h5>
                            <p>Promenade dans les ruelles anciennes de la médina et de la Kasbah</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 2 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Tanger</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--zellige-turquoise); color: white;">Réserver</a>
                        </div>
                    </div>


                    <!-- Sahara Camel Trek -->
                    <div class="activity-card" data-category="desert">
                        <img src="assets/images/MerzougaCamelRiding.jpg" alt="Trek à dos de chameau">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--spice-orange);">Désert</span>
                            <h5>Trek en Chameau</h5>
                            <p>Traversez les dunes dorées jusqu’à un campement de luxe</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 2 Jours</span>
                                <span><i class="fas fa-map-marker-alt"></i> Merzouga</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--spice-orange); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Marrakech Souk Tour -->
                    <div class="activity-card" data-category="cultural">
                        <img src="assets/images/MarrakeshSouk.jpg" alt="Marrakech Souk">
                        <div class="card-body">
                            <span class="activity-badge"
                                style="background-color: var(--zellige-turquoise);">Culturel</span>
                            <h5>Visite des Souks</h5>
                            <p>Flânez dans les souks animés avec un guide local</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 4 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Marrakech</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--zellige-turquoise); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Merzouga Sandboarding -->
                    <div class="activity-card" data-category="desert">
                        <img src="assets/images/SandBoardingSahara.jpg" alt="Sandboard Sahara">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--spice-orange);">Désert</span>
                            <h5>Sandboard à Merzouga</h5>
                            <p>Glissez sur les dunes de l’Erg Chebbi</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 1 Jour</span>
                                <span><i class="fas fa-map-marker-alt"></i> Merzouga</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--spice-orange); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Essaouira Surfing -->
                    <div class="activity-card" data-category="coastal">
                        <img src="assets/images/EssaSurf.jpg" alt="Surf Essaouira">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--majorelle-blue);">Côtier</span>
                            <h5>Surf à Essaouira</h5>
                            <p>Dominez les vagues de l’Atlantique avec un coach local</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 1 Jour</span>
                                <span><i class="fas fa-map-marker-alt"></i> Essaouira</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--majorelle-blue); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Desert Stargazing -->
                    <div class="activity-card" data-category="desert">
                        <img src="assets/images/MerzougaStarGazing.jpg" alt="Observation étoiles">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--spice-orange);">Désert</span>
                            <h5>Nuit sous les étoiles</h5>
                            <p>Admirez la Voie lactée depuis un campement berbère</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 1 Nuit</span>
                                <span><i class="fas fa-map-marker-alt"></i> Merzouga</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--spice-orange); color: white;">Réserver</a>
                        </div>
                    </div>


                    <!-- Fes Tannery Visit -->
                    <div class="activity-card" data-category="cultural">
                        <img src="assets/images/FesTannery.jpg" alt="Tanneries Fès">
                        <div class="card-body">
                            <span class="activity-badge"
                                style="background-color: var(--zellige-turquoise);">Culturel</span>
                            <h5>Découverte des Tanneries</h5>
                            <p>Observez les techniques ancestrales du cuir à Fès</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 2 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Fès</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--zellige-turquoise); color: white;">Réserver</a>
                        </div>
                    </div>

                    <!-- Agadir Cooking -->
                    <div class="activity-card" data-category="coastal">
                        <img src="assets/images/AgadirSeaFood.jpg" alt="Cuisine Agadir">
                        <div class="card-body">
                            <span class="activity-badge" style="background-color: var(--majorelle-blue);">Côtier</span>
                            <h5>Atelier Cuisine</h5>
                            <p>Préparez un tajine de poisson marocain face à la mer</p>
                            <div class="activity-meta">
                                <span><i class="fas fa-clock"></i> 5 Heures</span>
                                <span><i class="fas fa-map-marker-alt"></i> Agadir</span>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm mt-3"
                                style="background-color: var(--majorelle-blue); color: white;">Réserver</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Carousel -->
            <div class="carousel-nav mt-4 text-center">
                <button class="carousel-prev btn btn-outline-secondary me-2"><i
                        class="fas fa-chevron-left"></i></button>
                <div id="activities-dots" class="carousel-dots d-inline-block mx-2"></div>
                <button class="carousel-next btn btn-outline-secondary ms-2"><i
                        class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- ======= SPECIAL OFFERS ======= -->
    <section id="offers" class="container my-5 py-4">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Offres Exclusives <span
                    style="color: var(--majorelle-blue);">Marocaines</span></h2>
            <p class="lead">Des offres limitées pour des expériences inoubliables</p>
            <div class="d-flex justify-content-center">
                <div class="border-bottom border-3" style="width: 80px;"></div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Offre 1  -->
            <div class="col-md-6 col-lg-4">
                <div class="card offer-card h-100 border-0 shadow-sm hover-scale">
                    <div class="position-relative">
                        <img src="assets/images/CampSahara.jpg" class="card-img-top" alt="Camp du Sahara"
                            style="height: 200px; object-fit: cover;">
                        <div
                            class="offer-badge bg-danger text-white px-3 py-1 position-absolute top-0 end-0 m-2 rounded-pill">
                            <small>-25%</small>
                        </div>
                        <div
                            class="offer-timer position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2">
                            <i class="fas fa-clock me-1"></i> <small>Se termine dans : <span class="countdown"
                                    data-end="2025-06-30T23:59:59"></span>
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Camp de luxe dans le Sahara</h5>
                        <p class="card-text">Expérience premium de 3 jours avec trek à dos de chameau et observation des
                            étoiles</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-decoration-line-through text-muted me-2">€450</span>
                                <span class="fw-bold text-danger">€337</span>
                                <small class="text-muted d-block">par personne</small>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm btn-warning">Profiter de
                                l'offre</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offre 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card offer-card h-100 border-0 shadow-sm hover-scale">
                    <div class="position-relative">
                        <img src="assets/images/MarrakechRiad.jpg" class="card-img-top" alt="Marrakech Riad"
                            style="height: 200px; object-fit: cover;">
                        <div
                            class="offer-badge bg-success text-white px-3 py-1 position-absolute top-0 end-0 m-2 rounded-pill">
                            <small>Combo</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Pack Villes Impériales</h5>
                        <p class="card-text">Circuit de 5 jours Marrakech + Fès avec séjours en riads boutique</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-success">€599</span>
                                <small class="text-muted d-block">(économie de €150)</small>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm btn-outline-warning">Voir les
                                détails</a>
                        </div>
                        <div class="mt-3 bg-light p-2 rounded text-center">
                            <small><i class="fas fa-gift text-warning me-1"></i> <strong>GRATUIT</strong> Bon hammam
                                inclus</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offre 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card offer-card h-100 border-0 shadow-sm hover-scale">
                    <div class="position-relative">
                        <img src="assets/images/AgadirHotel.jpg" class="card-img-top"
                            alt="Sofitel Agadir Thalassa Sea & Spa" style="height: 200px; object-fit: cover;">
                        <div
                            class="offer-badge bg-info text-white px-3 py-1 position-absolute top-0 end-0 m-2 rounded-pill">
                            <small>Offre spéciale</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Séjour de Luxe à Agadir</h5>
                        <p class="card-text">Profitez d'un séjour inoubliable au Sofitel Agadir Thalassa Sea & Spa, face
                            à l'océan Atlantique.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-info">À partir de €280</span>
                                <small class="text-muted d-block">(offre spéciale 2025)</small>
                            </div>
                            <a href="frontend/connexion/index.html" class="btn btn-sm btn-warning">Réserver
                                maintenant</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="frontend/connexion/index.html" class="btn btn-lg btn-outline-warning px-4">
                Voir les 12 offres spéciales <i class="fas fa-chevron-right ms-2"></i>
            </a>
        </div>
    </section>



    <!-- Why Choose Us -->
    <section class="py-5" style="background-color: var(--majorelle-blue); color: white;">
        <div class="container">
            <h2 class="text-center mb-5">Pourquoi choisir TouraMaroc ?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h4>Experts Locaux</h4>
                    <p>Nos guides connaissent les trésors cachés du Maroc.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4>Expériences Authentiques</h4>
                    <p>Plongez profondément dans la culture marocaine.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Sécurité & Fiabilité</h4>
                    <p>Recommandé par des milliers de voyageurs.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="/frontend/user/pages/terms/index.php"
                        class="text-white-50 text-decoration-none small">Terms</a>
                    <a href="/frontend/user/pages/privacy/index.php"
                        class="text-white-50 text-decoration-none small">Privacy</a>
                    <a href="/frontend/user/pages/faq/index.php"
                        class="text-white-50 text-decoration-none small">FAQ</a>
                </div>
                <span class="text-white-50 d-none d-sm-block">|</span>
                <div class="d-flex align-items-center gap-2">
                    <a href="" class="text-white" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="" class="text-white" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="" class="text-white" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
                <span class="text-white-50 d-none d-sm-block">|</span>

                <p class="small text-white-50 mb-0">&copy; 2025 TouraMaroc</p>
            </div>
        </div>
    </footer>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>