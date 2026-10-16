-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 oct. 2026 à 23:16
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tunisiestay`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `note` smallint(6) NOT NULL,
  `commentaire` longtext DEFAULT NULL,
  `note_nettete` smallint(6) DEFAULT NULL,
  `note_emplacement` smallint(6) DEFAULT NULL,
  `note_rapport_qualite` smallint(6) DEFAULT NULL,
  `reponse_proprietaire` longtext DEFAULT NULL,
  `est_visible` tinyint(4) NOT NULL,
  `cree_le` datetime NOT NULL,
  `voyageur_id` int(11) NOT NULL,
  `logement_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `note`, `commentaire`, `note_nettete`, `note_emplacement`, `note_rapport_qualite`, `reponse_proprietaire`, `est_visible`, `cree_le`, `voyageur_id`, `logement_id`, `reservation_id`) VALUES
(1, 5, 'Séjour exceptionnel ! Le chalet était parfaitement propre, confortable et très bien équipé. L’endroit est calme et idéal pour se détendre. La vue est magnifique et l’ambiance chaleureuse nous a vraiment permis de profiter pleinement de notre séjour. L’accueil était également très agréable et professionnel. Je recommande vivement et je reviendrai sans hésiter !', 5, 5, 5, NULL, 1, '2026-05-02 19:04:40', 3, 2, NULL),
(2, 5, 'Très beau séjour ! Le chalet est propre, confortable et bien équipé. L’endroit est calme, parfait pour se détendre, avec une vue magnifique. L’accueil était chaleureux et professionnel. Je recommande sans hésiter !', 4, 5, 4, NULL, 1, '2026-05-02 19:06:54', 4, 2, NULL),
(3, 4, 'Séjour incroyable ! La villa est magnifique, avec une vue imprenable sur la mer. Tout était propre, spacieux et très bien aménagé. Le bruit des vagues et l’accès facile à la plage rendent l’expérience encore plus relaxante. L’accueil était chaleureux et tout s’est déroulé parfaitement. Je recommande vivement cette villa pour des vacances inoubliables !', 5, 5, 4, NULL, 1, '2026-05-02 19:08:08', 4, 4, NULL),
(4, 5, 'Séjour ressourçant et inoubliable ! La maison d’hôtes est nichée dans un cadre naturel magnifique, idéal pour se déconnecter et profiter du calme. L’endroit est très propre, chaleureux et décoré avec goût. Les hôtes sont accueillants, attentionnés et toujours disponibles. On se sent comme chez soi, avec en plus le charme de la nature tout autour. Je recommande vivement pour une vraie pause détente ! 🌿', 5, 5, 5, NULL, 1, '2026-05-02 19:08:55', 4, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `config_commission`
--

CREATE TABLE `config_commission` (
  `id` int(11) NOT NULL,
  `taux` decimal(10,2) NOT NULL,
  `montant_min` decimal(10,2) DEFAULT NULL,
  `montant_max` decimal(10,2) DEFAULT NULL,
  `est_active` tinyint(4) NOT NULL,
  `cree_le` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `config_commission`
--

INSERT INTO `config_commission` (`id`, `taux`, `montant_min`, `montant_max`, `est_active`, `cree_le`) VALUES
(1, 12.00, NULL, NULL, 0, '2026-04-29 23:50:18'),
(2, 12.00, NULL, NULL, 0, '2026-04-29 23:50:18'),
(3, 15.00, NULL, NULL, 0, '2026-04-29 23:50:29'),
(4, 10.00, NULL, NULL, 1, '2026-05-02 00:17:43');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `est_disponible` tinyint(4) NOT NULL,
  `prix_personnalise` decimal(10,2) DEFAULT NULL,
  `logement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260421175601', NULL, NULL),
('DoctrineMigrations\\Version20260421182322', '2026-04-21 20:24:23', 142),
('DoctrineMigrations\\Version20260501191926', '2026-05-01 21:19:52', 83),
('DoctrineMigrations\\Version20260502165320', '2026-05-02 18:53:22', 215);

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `icone` varchar(100) NOT NULL,
  `categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`id`, `nom`, `icone`, `categorie`) VALUES
(1, 'Wi-Fi', '📶', 'basique'),
(2, 'Piscine', '🏊', 'loisir'),
(3, 'Climatisation', '❄️', 'confort'),
(4, 'Cuisine équipée', '🍳', 'basique'),
(5, 'TV', '📺', 'basique'),
(6, 'Parking gratuit', '🚗', 'pratique');

-- --------------------------------------------------------

--
-- Structure de la table `equipement_logement`
--

CREATE TABLE `equipement_logement` (
  `equipement_id` int(11) NOT NULL,
  `logement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipement_logement`
--

INSERT INTO `equipement_logement` (`equipement_id`, `logement_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(5, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Structure de la table `favori`
--

CREATE TABLE `favori` (
  `id` int(11) NOT NULL,
  `ajoute_le` datetime NOT NULL,
  `voyageur_id` int(11) NOT NULL,
  `logement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favori`
--

INSERT INTO `favori` (`id`, `ajoute_le`, `voyageur_id`, `logement_id`) VALUES
(1, '2026-05-01 18:33:26', 3, 1),
(2, '2026-05-02 00:52:04', 4, 4),
(3, '2026-05-02 19:12:15', 4, 3),
(4, '2026-05-02 19:12:25', 4, 1),
(5, '2026-05-02 19:13:24', 3, 4),
(6, '2026-05-02 19:13:33', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

CREATE TABLE `logement` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `description` longtext NOT NULL,
  `type` varchar(50) NOT NULL,
  `statut` varchar(30) NOT NULL,
  `prix_par_nuit` decimal(10,2) NOT NULL,
  `devise` varchar(3) NOT NULL,
  `max_voyageurs` smallint(6) NOT NULL,
  `chambres` smallint(6) NOT NULL,
  `salles_de_bain` smallint(6) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `cree_le` datetime NOT NULL,
  `modifie_le` datetime DEFAULT NULL,
  `proprietaire_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logement`
--

INSERT INTO `logement` (`id`, `titre`, `slug`, `description`, `type`, `statut`, `prix_par_nuit`, `devise`, `max_voyageurs`, `chambres`, `salles_de_bain`, `latitude`, `longitude`, `adresse`, `ville`, `region`, `cree_le`, `modifie_le`, `proprietaire_id`) VALUES
(1, 'Chalets à Jendouba', 'chalets-a-jendouba-69f260e407ff3', 'Vous recherchez un chalet d\'exception construit en bois au cœur du foret d’Ain Drahamn avec une superbe vue sur la montagne rocheuse? A TunisiaStay vous passerez un séjour d\'exception entre amis dans un chalet superbe et parfaitement équipé, vous goûterez aux privilèges de d\'une intimité préservée.\n\nAu RDC vous trouvez une chambre avec 2 lits simples, ainsi à l\'étage une deuxième chambre avec un lit double. Profitez du salon bien meublé et climatisé ouvert sur la cuisine avec un coin cheminée qui vous permet de profiter largement de la lumière naturelle et de la vue sur les montagnes d’Ain Draham.', 'chalet', 'publie', 600.00, 'TND', 5, 2, 1, 36.501, 8.776, 'rue : Bou Alel Slim', 'Jendouba', 'Ain Draham', '2026-04-29 21:49:56', '2026-04-29 23:33:03', 2),
(2, 'Le Chalet Du bois', 'le-chalet-du-bois-69f50d1f813a2', 'Avec une vue panoramique sur la belle plage belge de kélibia et une capacité de 8 personnes, le Chalet en bois est un auberge entièrement privatisable, offrant un confort absolu pour vous évader pendant les vacances, week-ends ou fêtes privés en famille ou entre amis.\n\nEn Hiver comme en été, venez profiter de la maison composée de 3 chambres à coucher, un salon, une salle à manger, une cuisine hautement équipée sans oublier la cheminée traditionnelle.', 'chalet', 'publie', 850.00, 'TND', 8, 3, 4, 36.806, 10.181, 'rue: liberte', 'nabeul', 'klibia', '2026-05-01 22:29:19', '2026-05-01 22:29:19', 2),
(3, 'Dar Zaghouan', 'dar-zaghouan-69f51e60114ae', 'Bienvenue dans la charmante maison d\'hôtes Dar Zaghouan située au cœur de la nature, où le luxe et le confort s\'entrelacent pour créer une expérience inoubliable. L’établissement se compose de deux chalets élégamment conçus, offrant un refuge exclusif et paisible pour nos hôtes.\n\nA Dar Zaghouan les chambres sont de luxe haut de gamme, décorées avec raffinement, vous accueillent dans un cocon de confort. Chaque détail a été soigneusement pensé pour créer une atmosphère chaleureuse et relaxante, Pour vous détendre et vous rafraîchir, plongez dans la magnifique piscine entourée d\'un jardin luxuriant. Pour une expérience ultime de relaxation, le centre de spa vous attend. Offrant une gamme complète de soins apaisants, le spa est l\'endroit parfait pour échapper au stress quotidien et retrouver votre équilibre intérieur.', 'maison_hote', 'publie', 260.00, 'TND', 10, 6, 6, 36.402, 10.143, 'Zaghouan', 'Zaghouan', 'Zaghouan', '2026-05-01 23:42:56', '2026-05-01 23:42:56', 2),
(4, 'Villa Mila', 'villa-mila-69f522ed6ae24', 'Situé à Al Matlīn, l’hébergement Villa Mila 6 Suites Piscine Vue Mer Metline offre une vue sur le jardin. Il propose une piscine extérieure, une terrasse et une connexion Wi-Fi gratuite. Cette villa comprend une piscine privée, un jardin et un parking privé gratuit.\n\nCette villa avec climatisation se compose de 6 chambres, d’une cuisine et de 6 salles de bains. Une télévision à écran plat est disponible.\n\nL\'aéroport le plus proche (Aéroport de Tunis-Carthage) est à 60 km', 'villa', 'publie', 2000.00, 'TND', 12, 6, 6, 37.274, 9.873, 'mitline', 'bizerte', 'mitline', '2026-05-02 00:02:21', '2026-05-02 00:02:21', 2);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `type_mime` varchar(100) NOT NULL,
  `taille` int(11) DEFAULT NULL,
  `position` smallint(6) NOT NULL,
  `type` varchar(10) NOT NULL,
  `logement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `nom_fichier`, `type_mime`, `taille`, `position`, `type`, `logement_id`) VALUES
(1, 'tiny-home-1-1-69f2790f40ed0.jpg', 'image/jpeg', NULL, 0, 'image', 1),
(2, 'tiny-home-2-69f2790f48a7c.jpg', 'image/jpeg', NULL, 0, 'image', 1),
(3, 'tiny-home-3-69f2790f4a4eb.jpg', 'image/jpeg', NULL, 0, 'image', 1),
(4, 'tiny-home-4-69f2790f4bcbc.jpg', 'image/jpeg', NULL, 0, 'image', 1),
(5, 'le-chalet-du-bois-69f50d1f850da.jpg', 'image/jpeg', NULL, 0, 'image', 2),
(6, 'le-chalet-du-bois-1-69f50d1f897e7.jpg', 'image/jpeg', NULL, 0, 'image', 2),
(7, 'le-chalet-du-bois-2-69f50d1f8a3ea.jpg', 'image/jpeg', NULL, 0, 'image', 2),
(8, 'le-chalet-du-bois-3-69f50d1f8b395.jpg', 'image/jpeg', NULL, 0, 'image', 2),
(9, 'le-chalet-du-bois-4-69f50d1f8c000.jpg', 'image/jpeg', NULL, 0, 'image', 2),
(10, 'dar-zaghouan-69f51e6016c7e.jpg', 'image/jpeg', NULL, 0, 'image', 3),
(11, 'dar-zaghouan-1-69f51e601dff6.jpg', 'image/jpeg', NULL, 0, 'image', 3),
(12, 'dar-zaghouan-2-69f51e601f4e8.jpg', 'image/jpeg', NULL, 0, 'image', 3),
(13, 'dar-zaghouan-3-69f51e6020f51.jpg', 'image/jpeg', NULL, 0, 'image', 3),
(14, 'dar-zaghouan-4-69f51e602220e.jpg', 'image/jpeg', NULL, 0, 'image', 3),
(15, 'villa-1-69f522ed70aaa.jpg', 'image/jpeg', NULL, 0, 'image', 4),
(16, 'villa-2-69f522ed79f74.jpg', 'image/jpeg', NULL, 0, 'image', 4),
(17, 'villa-3-69f522ed7b61f.jpg', 'image/jpeg', NULL, 0, 'image', 4),
(18, 'villa-4-69f522ed7d083.jpg', 'image/jpeg', NULL, 0, 'image', 4),
(19, 'villa-5-69f522ed7ec85.jpg', 'image/jpeg', NULL, 0, 'image', 4),
(20, 'villa-6-69f522ed8098d.jpg', 'image/jpeg', NULL, 0, 'image', 4);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;N;i:1;N;i:2;s:1356:\\\"\n                        <div style=\\\'font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;\\\'>\n                            <h2 style=\\\'color: #1E3A5F; text-align: center;\\\'>TunisiaStay</h2>\n                            <p>Bonjour yassine,</p>\n                            <p>Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour continuer :</p>\n                            <div style=\\\'text-align: center; margin: 30px 0;\\\'>\n                                <a href=\\\'http://127.0.0.1:8000/reset-password/b6310bb4dea4046106199da6b263ad96088ccd87f90092bf4e68d68b80ea2e46\\\' style=\\\'background: #F0A500; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;\\\'>Réinitialiser mon mot de passe</a>\n                            </div>\n                            <p>Ce lien est valable pendant 1 heure.</p>\n                            <p>Si vous n\\\'êtes pas à l\\\'origine de cette demande, vous pouvez ignorer cet email.</p>\n                            <hr style=\\\'border: 0; border-top: 1px solid #eee; margin: 20px 0;\\\'>\n                            <p style=\\\'font-size: 12px; color: #888; text-align: center;\\\'>TunisiaStay — Votre séjour d\\\'exception en Tunisie</p>\n                        </div>\n                    \\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:24:\\\"no-reply@tunisiastay.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:28:\\\"yassineaounallah22@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:55:\\\"Réinitialisation de votre mot de passe — TunisiaStay\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2026-05-01 19:37:22', '2026-05-01 19:37:22', NULL),
(2, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;N;i:1;N;i:2;s:1356:\\\"\n                        <div style=\\\'font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;\\\'>\n                            <h2 style=\\\'color: #1E3A5F; text-align: center;\\\'>TunisiaStay</h2>\n                            <p>Bonjour yassine,</p>\n                            <p>Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour continuer :</p>\n                            <div style=\\\'text-align: center; margin: 30px 0;\\\'>\n                                <a href=\\\'http://127.0.0.1:8000/reset-password/e4a0e68b80170a035fef4b545e2a261823ec5bc7e684e09108be43b0a1bdcfd4\\\' style=\\\'background: #F0A500; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;\\\'>Réinitialiser mon mot de passe</a>\n                            </div>\n                            <p>Ce lien est valable pendant 1 heure.</p>\n                            <p>Si vous n\\\'êtes pas à l\\\'origine de cette demande, vous pouvez ignorer cet email.</p>\n                            <hr style=\\\'border: 0; border-top: 1px solid #eee; margin: 20px 0;\\\'>\n                            <p style=\\\'font-size: 12px; color: #888; text-align: center;\\\'>TunisiaStay — Votre séjour d\\\'exception en Tunisie</p>\n                        </div>\n                    \\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:24:\\\"no-reply@tunisiastay.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:28:\\\"yassineaounallah22@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:55:\\\"Réinitialisation de votre mot de passe — TunisiaStay\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2026-05-01 19:54:57', '2026-05-01 19:54:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `devise` varchar(3) NOT NULL,
  `stripe_intention_id` varchar(255) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `paye_le` datetime DEFAULT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `montant`, `devise`, `stripe_intention_id`, `statut`, `paye_le`, `reservation_id`) VALUES
(1, 1955.00, 'TND', 'pi_3TSOaTKHOB3XfYxE09GuLmw5', 'en_attente', NULL, 5),
(2, 3300.00, 'TND', 'pi_3TSg5vKHOB3XfYxE0Jh6wXUU', 'en_attente', NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `date_arrivee` date NOT NULL,
  `date_depart` date NOT NULL,
  `nb_voyageurs` smallint(6) NOT NULL,
  `nb_nuits` smallint(6) NOT NULL,
  `montant_base` decimal(10,2) NOT NULL,
  `taux_commission` decimal(10,2) NOT NULL,
  `montant_commission` decimal(10,2) NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `devise` varchar(3) NOT NULL,
  `montant_en_eur` decimal(10,2) DEFAULT NULL,
  `statut` varchar(20) NOT NULL,
  `cree_le` datetime NOT NULL,
  `confirme_le` datetime DEFAULT NULL,
  `annule_le` datetime DEFAULT NULL,
  `voyageur_id` int(11) NOT NULL,
  `logement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `date_arrivee`, `date_depart`, `nb_voyageurs`, `nb_nuits`, `montant_base`, `taux_commission`, `montant_commission`, `montant_total`, `devise`, `montant_en_eur`, `statut`, `cree_le`, `confirme_le`, `annule_le`, `voyageur_id`, `logement_id`) VALUES
(2, '2026-04-29', '2026-04-29', 1, 0, 0.00, 12.00, 0.00, 0.00, 'TND', NULL, 'annule', '2026-04-29 23:40:31', NULL, '2026-04-29 23:51:30', 3, 1),
(3, '2026-04-29', '2026-04-29', 1, 0, 0.00, 12.00, 0.00, 0.00, 'TND', NULL, 'annule', '2026-04-29 23:48:14', NULL, '2026-04-29 23:51:21', 3, 1),
(4, '2026-04-30', '2026-05-03', 5, 3, 2550.00, 15.00, 382.50, 2932.50, 'TND', NULL, 'annule', '2026-05-01 22:56:56', NULL, '2026-05-01 23:26:35', 3, 2),
(5, '2026-04-30', '2026-05-02', 1, 2, 1700.00, 15.00, 255.00, 1955.00, 'TND', NULL, 'termine', '2026-05-01 23:27:01', '2026-05-02 18:07:04', NULL, 3, 2),
(6, '2026-05-01', '2026-05-06', 3, 5, 3000.00, 10.00, 300.00, 3300.00, 'TND', NULL, 'termine', '2026-05-02 18:08:38', '2026-05-02 18:12:13', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `langue` varchar(5) NOT NULL,
  `est_verifie` tinyint(4) NOT NULL,
  `compte_stripe_id` varchar(255) DEFAULT NULL,
  `cree_le` datetime NOT NULL,
  `modifie_le` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `prenom`, `nom`, `telephone`, `avatar_url`, `langue`, `est_verifie`, `compte_stripe_id`, `cree_le`, `modifie_le`, `reset_token`, `reset_token_expires_at`) VALUES
(1, 'eljedtasnime5@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$zJypoZVaC/U3KMeP3opVg.vE4K1jVPXG27Yu359FHaLc7/pGI6KJq', 'tasnime', 'eljed', NULL, NULL, 'fr', 0, NULL, '2026-04-21 20:28:15', NULL, 'c99b0b397dd7d3bf95491c7c523fc9027d1bd663008d00db85bc2332da1ab9d5', '2026-05-01 22:22:59'),
(2, 'yassineaounallah22@gmail.com', '[\"ROLE_OWNER\"]', '$2y$13$b8OyZNOX5DDGoftWEIVx4OGCyOmBtMRJ/AmoCPLdc7v4eIMkWitRG', 'yassine', 'aounallah', '22949944', '69f52e1c8fda8.jpg', 'fr', 0, NULL, '2026-04-21 20:29:39', NULL, NULL, NULL),
(3, 'elaabdenebi@gmail.com', '[\"ROLE_TRAVELER\"]', '$2y$13$Szf/irsGnMVRK9NyP7vP5eJHP/UyNNg4ewF4QX2/kNQFv5IeCWtFa', 'ela', 'abdenebi', '90252103', '69f52ce2eb6f7.jpg', 'fr', 0, NULL, '2026-04-29 19:29:05', NULL, NULL, NULL),
(4, 'tassouJed@gmail.com', '[\"ROLE_TRAVELER\"]', '$2y$13$DnqbuKDDS7QnCJRg9UsiWOidikSDMmK/a0tMats1REG0ZtjW5RUoa', 'tassou', 'jed', '24569313', '69f52f63732db.jpg', 'fr', 0, NULL, '2026-05-02 00:51:32', NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8F91ABF0B83297E7` (`reservation_id`),
  ADD KEY `IDX_8F91ABF062915402` (`voyageur_id`),
  ADD KEY `IDX_8F91ABF058ABF955` (`logement_id`);

--
-- Index pour la table `config_commission`
--
ALTER TABLE `config_commission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2CBACE2F58ABF955` (`logement_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipement_logement`
--
ALTER TABLE `equipement_logement`
  ADD PRIMARY KEY (`equipement_id`,`logement_id`),
  ADD KEY `IDX_EF2C4A73806F0F5C` (`equipement_id`),
  ADD KEY `IDX_EF2C4A7358ABF955` (`logement_id`);

--
-- Index pour la table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EF85A2CC62915402` (`voyageur_id`),
  ADD KEY `IDX_EF85A2CC58ABF955` (`logement_id`);

--
-- Index pour la table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F0FD445776C50E4A` (`proprietaire_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6A2CA10C58ABF955` (`logement_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B1DC7A1EB83297E7` (`reservation_id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_42C8495562915402` (`voyageur_id`),
  ADD KEY `IDX_42C8495558ABF955` (`logement_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `config_commission`
--
ALTER TABLE `config_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `favori`
--
ALTER TABLE `favori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `logement`
--
ALTER TABLE `logement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `FK_8F91ABF058ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_8F91ABF062915402` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_8F91ABF0B83297E7` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`);

--
-- Contraintes pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `FK_2CBACE2F58ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`);

--
-- Contraintes pour la table `equipement_logement`
--
ALTER TABLE `equipement_logement`
  ADD CONSTRAINT `FK_EF2C4A7358ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EF2C4A73806F0F5C` FOREIGN KEY (`equipement_id`) REFERENCES `equipement` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `FK_EF85A2CC58ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_EF85A2CC62915402` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `logement`
--
ALTER TABLE `logement`
  ADD CONSTRAINT `FK_F0FD445776C50E4A` FOREIGN KEY (`proprietaire_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C58ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_B1DC7A1EB83297E7` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C8495558ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_42C8495562915402` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
