-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 23 juin 2025 à 03:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `touramaroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

CREATE TABLE `activites` (
  `activite_id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `ville_id` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `activite_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`activite_id`, `titre`, `ville_id`, `prix`, `dateDebut`, `dateFin`, `activite_description`) VALUES
(5, 'Balade à dos de dromadaire', 25, 500.00, '2025-06-22', '2025-06-24', 'Les activités dans le désert du Sahara offrent une immersion inoubliable dans un univers unique, allant des balades à dos de dromadaire au coucher du soleil, aux nuits magiques en bivouac sous les étoiles, en passant par les randonnées dans les dunes, les excursions en 4x4 ou en quad pour explorer les ergs et oasis, ainsi que des expériences culturelles riches auprès des nomades berbères avec musique traditionnelle et cuisine locale autour du feu.'),
(6, 'Visite guidée de la médina	', 24, 200.00, '2025-06-22', '2025-06-25', 'Découverte des souks, monuments historiques et ruelles emblématiques avec un guide local.');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `blog_id` int(11) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_blog` date NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`blog_id`, `auteur`, `titre`, `contenu`, `date_blog`, `image`) VALUES
(2, 'admin', 'A Taste of Morocco: Discovering Traditional Moroccan Cuisine', 'Moroccan cuisine is one of the richest and most diverse in the world. It is the result of centuries of cultural exchange between Arab, Berber, Andalusian, African, and Mediterranean influences. Each dish tells a story, whether it’s served in a family home, a traditional restaurant, or a food stall in a busy souk.\r\n\r\nOne of the most iconic Moroccan dishes is the Tajine, named after the clay pot in which it is cooked. There are countless variations, from lamb with prunes and almonds to chicken with preserved lemons and olives. The slow cooking method brings out deep flavors and keeps the meat tender and juicy.\r\nCouscous is another national treasure. Usually served on Fridays after prayer, it consists of steamed semolina grains topped with vegetables, meat, and a flavorful broth. It’s not just food — it’s part of Moroccan identity and family tradition.\r\nFor something sweet and savory, there is Pastilla — a flaky pastry made with layers of thin dough, filled with spiced meat (often pigeon or chicken), almonds, and cinnamon, then dusted with powdered sugar. It may sound unusual, but it’s a delicacy especially served during special occasions.\r\n\r\nMoroccan street food is also worth exploring. In the medinas, you’ll find Briouates (fried pastry stuffed with meat or cheese), Maakouda (potato fritters), and grilled meats sold at every corner. A popular favorite is Harira, a tomato-based soup with lentils and chickpeas, especially enjoyed during Ramadan to break the fast.\r\nNo Moroccan meal is complete without mint tea – known locally as ATAY Made with green tea, fresh mint leaves, and sugar, it’s not just a drink, but a symbol of hospitality. The way it’s served — with high pours into decorated glasses — is part of the charm.\r\nAnd don’t forget dessert. While fresh fruit is common, Moroccan sweets like Chebakia, Ghriba, and Sellou are enjoyed especially during religious holidays. These are made with ingredients like sesame seeds, honey, almonds, and spices.\r\n\r\nWhat makes Moroccan food unique is not just the ingredients, but the way it is shared. Meals are usually eaten from a communal dish, with everyone dipping bread and enjoying conversation. It’s a time for connection, laughter, and togetherness.\r\nWhether you are a food lover or just curious, exploring Moroccan cuisine is like taking a journey through the countrys soul. Each bite is filled with history, warmth, and flavor you won’t forget.', '2025-06-21', 'blog_0b080639cb7ba73b.jpg'),
(3, 'admin', 'The Beauty of Moroccan Architecture: A Journey Through Time', 'Moroccan architecture is one of the most iconic and admired styles in the world. From the majestic palaces of Marrakech to the quiet courtyards of Fes, Morocco’s buildings tell stories of the country’s spiritual roots, artistic excellence, and historical depth.\r\n\r\nThe heart of Moroccan architecture lies in its ability to combine function and beauty. The traditional Moroccan home, or Riad, is a perfect example. These houses are designed around an open-air courtyard, often with a fountain in the center, surrounded by rooms that open inward. This design provides privacy, shade, and peace — especially important in Islamic culture.\r\nOne of the most beautiful features of Moroccan buildings is Zellige — colorful, hand-cut ceramic tile mosaics arranged in geometric patterns. Zellige is not just decoration; it’s a form of art and spiritual expression. Alongside it, you’ll often find carved plaster work, cedar wood ceilings, and stucco arches that reflect centuries of Andalusian and Islamic influence.\r\nMosques and religious schools, known as medrassa, are another highlight of Moroccan architecture. The Al Quaraouiyine Mosque in Fes, founded in the 9th century, is considered one of the oldest universities in the world. Its architecture includes graceful arches, carved wooden doors, and peaceful courtyards that invite reflection and learning.\r\nOutside of religious buildings, Morocco also shines in its public spaces and palaces. The Bahia Palace in Marrakech, built in the 19th century, is a stunning display of Moroccan artistry. With its endless rooms, lush gardens, and mosaic-covered walls, it represents the finest in royal architecture.\r\n\r\nIn coastal cities like Essaouira and Asilah, Moroccan architecture takes on a different character. Influenced by Portuguese and Andalusian design, these towns feature white-washed walls, blue shutters, and seaside fortresses — creating a blend of Moroccan and Mediterranean charm.\r\nUrban planning is another part of Morocco’s architectural identity. The medina, or old city, is a maze of narrow streets, souks (markets), and traditional homes. Each medina has its own character: the spiritual calm of Fes, the buzz of Marrakech, the blue serenity of Chefchaouen. These spaces are designed to support community life, local commerce, and cultural preservation.\r\n\r\nToday, modern Moroccan architecture continues to evolve, blending tradition with innovation. Architects are creating eco-friendly homes, luxury riads, and cultural centers that respect the past while embracing the future. Cities like Casablanca are home to modern buildings like the Hassan II Mosque, one of the largest mosques in the world, featuring a towering minaret and an oceanfront view.\r\nIn every corner of Morocco, architecture reflects the country’s soul: proud, detailed, welcoming, and deeply connected to its identity. Whether you are exploring an ancient kasbah, relaxing in a riad, or walking through a medina, the architecture of Morocco will always leave you in awe.', '2025-06-21', 'blog_345d66c24b6a958a.jpg'),
(4, 'admin', 'Under the Stars: Experiencing the Magic of the Sahara Desert', 'The Sahara Desert is one of Morocco’s most unforgettable destinations. Covering a large part of the country’s southeast, it offers a once-in-a-lifetime experience for those who want to escape the city and reconnect with nature, silence, and ancient traditions.\r\nThe most popular way to explore the Moroccan Sahara is through a desert tour from cities like Marrakech or Fes. After hours of driving through the High Atlas Mountains and beautiful valleys, the golden dunes of Merzouga or Zagora suddenly appear on the horizon — endless waves of sand glowing under the sun.\r\n\r\nOne of the highlights of the desert experience is the Camel trek. Riding a camel into the dunes as the sun begins to set is like stepping into a dream. The silence, broken only by the wind and the soft steps of the camels, brings a sense of peace that’s hard to describe.\r\nAt night, travelers usually stay in desert camps — traditional Berber tents made from wool or leather. These camps range from basic to luxurious, but they all offer the same magic: sleeping under a sky filled with stars. With no city lights, the Sahara offers one of the clearest views of the night sky on Earth. The Milky Way, shooting stars, and constellations stretch above in breathtaking clarity.\r\nAround the campfire, local Berber guides often share stories, play drums, and sing traditional songs. It’s a moment of connection and discovery, far from the noise of the modern world. The desert teaches simplicity, patience, and appreciation for the natural beauty around us.\r\n\r\nThe Sahara is not just sand — it’s also full of life. Nomadic communities still live in remote areas, raising goats and camels, moving with the seasons. You may visit an oasis, see wild desert plants, or explore fossil-rich rock formations that date back millions of years.\r\n\r\nDesert mornings are just as magical. Waking up early to climb the dunes and watch the **sunrise** is a moment of silence and reflection. The first light paints the sand in soft pinks and golds, and the cool breeze reminds you how alive the desert truly is.\r\nWhether you are looking for adventure, spiritual connection, or cultural discovery, the Sahara Desert offers a journey like no other. It’s not just a place — it’s a feeling, a rhythm, and a memory that stays with you long after you leave.', '2025-06-21', 'blog_a5542ce2d07f4ad7.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `sujet` varchar(200) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `sujet`, `message`) VALUES
(1, 'Alice Benali', 'alice.benali@example.com', 'Demande de réservation', 'Bonjour, je souhaite réserver une excursion pour le 15 juillet.'),
(2, 'Karim Messaoudi', 'karim.messaoudi@example.com', 'Problème de paiement', 'Je n’ai pas reçu la confirmation après mon paiement. Pouvez-vous vérifier ?'),
(3, 'Nora El Fassi', 'nora.elfassi@example.com', 'Question sur le circuit', 'Le circuit dans le désert inclut-il les repas et le transport ?'),
(6, 'HAMID', 'zjlkz@GMAIL.COM', 'zjlkz@GMAIL.COM', 'zjlkz@GMAIL.COM');

-- --------------------------------------------------------

--
-- Structure de la table `detail_hebergements`
--

CREATE TABLE `detail_hebergements` (
  `id` int(11) NOT NULL,
  `id_hebergement` int(11) NOT NULL,
  `detail` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `detail_hebergements`
--

INSERT INTO `detail_hebergements` (`id`, `id_hebergement`, `detail`) VALUES
(12, 12, 'NADIE'),
(13, 13, 'NADIE');

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id_evenement` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `lieu` varchar(150) NOT NULL,
  `description_evenement` text NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id_evenement`, `nom`, `lieu`, `description_evenement`, `dateDebut`, `dateFin`) VALUES
(4, 'Festival International du Film	', '24', 'Festival cinématographique prestigieux réunissant stars, réalisateurs et amateurs de cinéma.\r\n', '2025-07-03', '2025-06-28'),
(5, 'Soirée Gnaoua & Fusion', '24', 'Concert live mêlant musique gnaoua traditionnelle et sons modernes dans un cadre en plein air.\r\n', '2025-07-04', '2025-07-05');

-- --------------------------------------------------------

--
-- Structure de la table `hebergements`
--

CREATE TABLE `hebergements` (
  `id` int(11) NOT NULL,
  `hebergement_id` int(11) NOT NULL,
  `type` enum('hotel','riad','maison') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `hebergements`
--

INSERT INTO `hebergements` (`id`, `hebergement_id`, `type`) VALUES
(12, 5, 'hotel'),
(13, 5, 'maison');

-- --------------------------------------------------------

--
-- Structure de la table `hebergement_images`
--

CREATE TABLE `hebergement_images` (
  `id` int(11) NOT NULL,
  `hebergement_id` int(11) NOT NULL,
  `urlSrc` varchar(255) NOT NULL,
  `alt` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `hebergement_images`
--

INSERT INTO `hebergement_images` (`id`, `hebergement_id`, `urlSrc`, `alt`) VALUES
(28, 12, 'discover the enigma of casablanca.png', 'Riad Marrakech'),
(29, 13, 'interior of hassan ii mosque, version 2 - peter sanders _ mosque, mosque architecture, islamic architecture.png', 'Maison Marrakech');

-- --------------------------------------------------------

--
-- Structure de la table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `etoiles` int(11) NOT NULL,
  `ville_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `hotel`
--

INSERT INTO `hotel` (`id`, `nom`, `prix`, `etoiles`, `ville_id`) VALUES
(5, 'Riad Marrakech', 900.00, 4, 24);

-- --------------------------------------------------------

--
-- Structure de la table `images_activites`
--

CREATE TABLE `images_activites` (
  `id_image_activites` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `urlSrc` varchar(400) NOT NULL,
  `altText` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_activites`
--

INSERT INTO `images_activites` (`id_image_activites`, `activite_id`, `urlSrc`, `altText`) VALUES
(10, 5, '9.png', 'Balade à dos de dromadaire'),
(11, 5, '18.png', 'Balade à dos de dromadaire'),
(12, 5, '19.png', 'Balade à dos de dromadaire'),
(13, 6, 'pexels-christophe-rascle-159591525-18767544.jpg', 'Visite guidée de la médina	'),
(14, 6, 'pexels-jean-marc-bonnel-387362531-14719655.jpg', 'Visite guidée de la médina	'),
(15, 6, 'pexels-mathias-dargnat-1141076318-20895317.jpg', 'Visite guidée de la médina	');

-- --------------------------------------------------------

--
-- Structure de la table `images_evenement`
--

CREATE TABLE `images_evenement` (
  `id_img_evenement` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  `urlSrc` varchar(255) NOT NULL,
  `alt` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_evenement`
--

INSERT INTO `images_evenement` (`id_img_evenement`, `id_evenement`, `urlSrc`, `alt`) VALUES
(10, 4, 'uploads/pexels-mographe-9143655.jpg', 'Festival International du Film	'),
(11, 5, 'uploads/30.png', 'Soirée Gnaoua & Fusion');

-- --------------------------------------------------------

--
-- Structure de la table `images_tour`
--

CREATE TABLE `images_tour` (
  `id_image_tour` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `urlSrc` varchar(400) NOT NULL,
  `altText` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_tour`
--

INSERT INTO `images_tour` (`id_image_tour`, `tour_id`, `urlSrc`, `altText`) VALUES
(6, 5, '20.png', 'Tour 3 jours dans le désert	'),
(7, 5, '21.png', 'Tour 3 jours dans le désert	'),
(8, 6, 'pexels-christophe-rascle-159591525-18767544.jpg', 'Tour Culturel Guidé de Marrakech	'),
(9, 6, 'pexels-diego-f-parra-33199-25489593.jpg', 'Tour Culturel Guidé de Marrakech	'),
(10, 6, 'pexels-mographe-30204571.jpg', 'Tour Culturel Guidé de Marrakech	');

-- --------------------------------------------------------

--
-- Structure de la table `images_ville`
--

CREATE TABLE `images_ville` (
  `id_image_ville` int(11) NOT NULL,
  `ville_id` int(11) NOT NULL,
  `urlSrc` varchar(400) NOT NULL,
  `altText` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_ville`
--

INSERT INTO `images_ville` (`id_image_ville`, `ville_id`, `urlSrc`, `altText`) VALUES
(30, 24, 'Guía-para-conocer-Fez-por-libre - Copy (2).png', 'Marrakech'),
(31, 25, 'Erg Chebbi, bucket list campfire in the middle of the desert with clear sky.png', 'Merzouga'),
(32, 25, 'Morocco Bucket List_ Spend a Night in the Sahara Desert!!!.png', 'Merzouga'),
(33, 26, 'fd74d2c5-e9d7-48be-8fe8-459b8e27c70f.png', 'Casablanca'),
(34, 26, 'hassan ii mosque stock image_ image of historical, casablanca - 43785851.png', 'Casablanca');

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

CREATE TABLE `maison` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `ville_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `maison`
--

INSERT INTO `maison` (`id`, `nom`, `prix`, `ville_id`) VALUES
(5, 'Maison Marrakech', 500.00, 25);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id_paiement` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `methode` varchar(150) NOT NULL,
  `statut` varchar(150) NOT NULL,
  `date_paiement` date NOT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id_paiement`, `montant`, `methode`, `statut`, `date_paiement`, `reservation_id`) VALUES
(1, 455.00, 'cash', 'réussi', '2025-06-22', 5),
(2, 455.00, 'cash', 'réussi', '2025-06-22', 4),
(3, 455.00, 'cash', 'réussi', '2025-06-22', 5),
(4, 455.00, 'cash', 'réussi', '2025-06-22', 4),
(5, 455.00, 'cash', 'réussi', '2025-06-23', 12);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `reserv_type` varchar(100) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `reserv_type`, `date_debut`, `date_fin`, `statut`, `user_id`) VALUES
(4, 'Hôtel', '2025-07-01', '2025-07-05', 'confirmée', 1),
(5, 'Excursion désert', '2025-08-10', '2025-08-12', 'confirmée', 1),
(12, 'Soirée', '2025-07-04', '2025-07-05', 'en attente', 1);

-- --------------------------------------------------------

--
-- Structure de la table `riads`
--

CREATE TABLE `riads` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `ville_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `ville_id` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `tour_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tours`
--

INSERT INTO `tours` (`tour_id`, `titre`, `ville_id`, `prix`, `dateDebut`, `dateFin`, `tour_description`) VALUES
(5, 'Tour 3 jours dans le désert	', 25, 1900.00, '2025-06-22', '2025-06-25', 'Circuit de 3 jours Marrakech–Ouarzazate–Merzouga, avec visite de l’Atlas, Ait Ben Haddou et nuit en bivouac.\r\n\r\n'),
(6, 'Tour Culturel Guidé de Marrakech	', 24, 400.00, '2025-06-26', '2025-06-23', 'Visite guidée des sites emblématiques de Marrakech : médina, souks, Koutoubia, palais Bahia et jardins Majorelle.\r\n\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `user_role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('actif','inactif') DEFAULT 'actif',
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `mot_de_passe`, `telephone`, `pays`, `ville`, `adresse`, `user_role`, `created_at`, `statut`, `is_admin`) VALUES
(1, 'Dupont', 'Marie', 'marie.dupont@example.com', '$2y$10$Vqhtz9qKaVpBzUoJ6yNfV.cC9.YB0loXErHF0FJ3SOEZ6Iz6uqAJC', '+33612345678', 'France', 'Paris', '123 Rue Lafayette', 'admin', '2025-06-22 17:09:55', 'actif', 0);

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `ville_id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `ville_description` text NOT NULL,
  `coordonnees` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`ville_id`, `nom`, `ville_description`, `coordonnees`) VALUES
(24, 'Marrakech', 'Marrakech, surnommée la Perle du Sud ou la Ville Rouge, est l\'une des plus célèbres villes du Maroc, tant pour son histoire riche que pour sa culture vibrante. Fondée au XIe siècle par les Almoravides, elle fut une capitale impériale à plusieurs reprises et demeure un centre économique, touristique et spirituel majeur du pays.', 'Latitude : 31.6295 Longitude : -7.9811'),
(25, 'Merzouga', 'Merzouga est un petit village saharien situé dans le sud-est du Maroc, célèbre pour ses dunes spectaculaires, notamment l’erg Chebbi. C’est l’un des lieux les plus prisés par les touristes souhaitant découvrir le désert du Sahara marocain.', 'Latitude : 31.1000° N  Longitude : -4.0000° W'),
(26, 'Casablanca', 'Casablanca, capitale économique du Maroc, est une métropole dynamique située sur la côte atlantique, mêlant modernité occidentale et charme marocain. Connue pour son architecture art déco et ses larges boulevards, la ville abrite la majestueuse mosquée Hassan II, l’une des plus grandes du monde, surplombant l’océan. C’est un centre névralgique du commerce, de la finance et de l’industrie, mais aussi une ville animée avec ses plages, ses cafés branchés, ses galeries d’art, et ses quartiers historiques comme l’ancienne médina ou le quartier des Habous. Casablanca séduit par son énergie urbaine, son ambiance cosmopolite et son ouverture sur le monde.', 'Latitude : 33.5731  , Longitude : -7.5898');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`activite_id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`blog_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `detail_hebergements`
--
ALTER TABLE `detail_hebergements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hebergement` (`id_hebergement`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id_evenement`);

--
-- Index pour la table `hebergements`
--
ALTER TABLE `hebergements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hebergement_images`
--
ALTER TABLE `hebergement_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hebergement_id` (`hebergement_id`);

--
-- Index pour la table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `images_activites`
--
ALTER TABLE `images_activites`
  ADD PRIMARY KEY (`id_image_activites`),
  ADD KEY `activite_id` (`activite_id`);

--
-- Index pour la table `images_evenement`
--
ALTER TABLE `images_evenement`
  ADD PRIMARY KEY (`id_img_evenement`),
  ADD KEY `id_evenement` (`id_evenement`);

--
-- Index pour la table `images_tour`
--
ALTER TABLE `images_tour`
  ADD PRIMARY KEY (`id_image_tour`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Index pour la table `images_ville`
--
ALTER TABLE `images_ville`
  ADD PRIMARY KEY (`id_image_ville`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `maison`
--
ALTER TABLE `maison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `riads`
--
ALTER TABLE `riads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`ville_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activites`
--
ALTER TABLE `activites`
  MODIFY `activite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `detail_hebergements`
--
ALTER TABLE `detail_hebergements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id_evenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `hebergements`
--
ALTER TABLE `hebergements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `hebergement_images`
--
ALTER TABLE `hebergement_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `images_activites`
--
ALTER TABLE `images_activites`
  MODIFY `id_image_activites` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `images_evenement`
--
ALTER TABLE `images_evenement`
  MODIFY `id_img_evenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `images_tour`
--
ALTER TABLE `images_tour`
  MODIFY `id_image_tour` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `images_ville`
--
ALTER TABLE `images_ville`
  MODIFY `id_image_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `riads`
--
ALTER TABLE `riads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `ville_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activites`
--
ALTER TABLE `activites`
  ADD CONSTRAINT `activites_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `detail_hebergements`
--
ALTER TABLE `detail_hebergements`
  ADD CONSTRAINT `detail_hebergements_ibfk_1` FOREIGN KEY (`id_hebergement`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `hebergement_images`
--
ALTER TABLE `hebergement_images`
  ADD CONSTRAINT `hebergement_images_ibfk_1` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images_activites`
--
ALTER TABLE `images_activites`
  ADD CONSTRAINT `images_activites_ibfk_1` FOREIGN KEY (`activite_id`) REFERENCES `activites` (`activite_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images_evenement`
--
ALTER TABLE `images_evenement`
  ADD CONSTRAINT `images_evenement_ibfk_1` FOREIGN KEY (`id_evenement`) REFERENCES `evenements` (`id_evenement`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images_tour`
--
ALTER TABLE `images_tour`
  ADD CONSTRAINT `images_tour_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images_ville`
--
ALTER TABLE `images_ville`
  ADD CONSTRAINT `images_ville_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maison`
--
ALTER TABLE `maison`
  ADD CONSTRAINT `maison_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id_reservation`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `riads`
--
ALTER TABLE `riads`
  ADD CONSTRAINT `riads_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`ville_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
