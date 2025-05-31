CREATE DATABASE IF NOT EXISTS touramaroc;
USE touramaroc;

-- USERS
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    user_role VARCHAR(50) NOT NULL
);

-- VILLES
CREATE TABLE IF NOT EXISTS villes (
    ville_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    ville_description TEXT NOT NULL,
    coordonnees VARCHAR(300) NOT NULL
);

-- IMAGES VILLES
CREATE TABLE IF NOT EXISTS images_ville (
    id_image_ville INT AUTO_INCREMENT PRIMARY KEY,
    ville_id INT NOT NULL,
    urlSrc VARCHAR(400) NOT NULL,
    altText VARCHAR(400) NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- TOURS
CREATE TABLE IF NOT EXISTS tours (
    tour_id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    ville_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    tour_description TEXT NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- IMAGES TOURS
CREATE TABLE IF NOT EXISTS images_tour (
    id_image_tour INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    urlSrc VARCHAR(400) NOT NULL,
    altText VARCHAR(400) NOT NULL,
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id) ON DELETE CASCADE
);

-- ACTIVITES
CREATE TABLE IF NOT EXISTS activites (
    activite_id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    ville_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    activite_description TEXT NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- IMAGES ACTIVITES
CREATE TABLE IF NOT EXISTS images_activites (
    id_image_activites INT AUTO_INCREMENT PRIMARY KEY,
    activite_id INT NOT NULL,
    urlSrc VARCHAR(400) NOT NULL,
    altText VARCHAR(400) NOT NULL,
    FOREIGN KEY (activite_id) REFERENCES activites(activite_id) ON DELETE CASCADE
);

-- HEBERGEMENTS
CREATE TABLE IF NOT EXISTS hebergements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hebergement_id INT NOT NULL,
    type ENUM('hotel', 'riad', 'maison') NOT NULL
);

-- HOTELS
CREATE TABLE IF NOT EXISTS hotel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    etoiles INT NOT NULL,
    ville_id INT NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- RIADS
CREATE TABLE IF NOT EXISTS riads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    ville_id INT NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- MAISONS
CREATE TABLE IF NOT EXISTS maison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    ville_id INT NOT NULL,
    FOREIGN KEY (ville_id) REFERENCES villes(ville_id) ON DELETE CASCADE
);

-- DETAILS HEBERGEMENTS
CREATE TABLE IF NOT EXISTS detail_hebergements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_hebergement INT NOT NULL,
    detail VARCHAR(400) NOT NULL,
    FOREIGN KEY (id_hebergement) REFERENCES hebergements(id) ON DELETE CASCADE
);

-- IMAGES HEBERGEMENTS
CREATE TABLE IF NOT EXISTS hebergement_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hebergement_id INT NOT NULL,
    urlSrc VARCHAR(255) NOT NULL,
    alt VARCHAR(150),
    FOREIGN KEY (hebergement_id) REFERENCES hebergements(id) ON DELETE CASCADE
);

-- EVENEMENTS
CREATE TABLE IF NOT EXISTS evenements (
    id_evenement INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    lieu VARCHAR(150) NOT NULL,
    description_evenement TEXT NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL
);

-- IMAGES EVENEMENTS
CREATE TABLE IF NOT EXISTS images_evenement (
    id_img_evenement INT AUTO_INCREMENT PRIMARY KEY,
    id_evenement INT NOT NULL,
    image_evenement VARCHAR(200) NOT NULL,
    image_event_url VARCHAR(200) NOT NULL,
    alt_text VARCHAR(150) NOT NULL,
    FOREIGN KEY (id_evenement) REFERENCES evenements(id_evenement) ON DELETE CASCADE
);

-- ARTICLES
CREATE TABLE IF NOT EXISTS articles (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    auteur VARCHAR(100) NOT NULL,
    titre VARCHAR(100) NOT NULL,
    contenu TEXT NOT NULL,
    date_blog DATE NOT NULL,
    image VARCHAR(200) NOT NULL
);

-- IMAGES ARTICLES
CREATE TABLE IF NOT EXISTS images_article (
    id_img_article INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    image_blog_url VARCHAR(200) NOT NULL,
    alt_text VARCHAR(100) NOT NULL,
    FOREIGN KEY (blog_id) REFERENCES articles(blog_id) ON DELETE CASCADE
);

-- RESERVATIONS
CREATE TABLE IF NOT EXISTS reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    reserv_type VARCHAR(100) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut VARCHAR(50),
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id_user) ON DELETE CASCADE
);

-- PAIEMENTS
CREATE TABLE IF NOT EXISTS paiements (
    id_paiement INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    methode VARCHAR(150) NOT NULL,
    statut VARCHAR(150) NOT NULL,
    date_paiement DATE NOT NULL,
    reservation_id INT NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id_reservation) ON DELETE CASCADE
);
