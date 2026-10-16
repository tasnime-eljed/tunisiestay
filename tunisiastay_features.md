# 📄 Rapport de Projet : TunisiaStay
**Plateforme de Réservation de Logements Touristiques en Tunisie**

## 🌟 Présentation Générale
TunisiaStay est une application web moderne développée avec **Symfony 7**, conçue pour connecter les voyageurs à la recherche d'hébergements d'exception (villas, riads, chalets) et les propriétaires locaux en Tunisie.

---

## 🛠️ Stack Technique
- **Framework** : Symfony 7.0+
- **Moteur de Template** : Twig (avec design responsive premium)
- **Base de Données** : MySQL / MariaDB (via Doctrine ORM)
- **Paiements** : Intégration Stripe (SCA ready)
- **Emails** : Symfony Mailer (Gmail SMTP)
- **Frontend** : Vanilla JS, CSS3 Moderne (Flexbox/Grid), Flatpickr (Calendriers)

---

## 👤 Gestion des Utilisateurs & Authentification
1. **Système de Rôles** :
   - **Voyageur** : Peut rechercher, réserver et gérer ses favoris.
   - **Propriétaire** : Peut publier et gérer ses logements et revenus.
   - **Administrateur** : Contrôle total sur les utilisateurs et les commissions.
2. **Authentification Sécurisée** :
   - Inscription et Connexion avec hachage de mot de passe (BCrypt).
   - **Mot de passe oublié** : Système de récupération par email avec token sécurisé.
3. **Profil Personnel** :
   - Modification des informations (Nom, Prénom, Téléphone).
   - **Avatar** : Téléchargement et mise à jour de la photo de profil.
   - **Sécurité** : Modification du mot de passe directement depuis le dashboard.

---

## 🏠 Fonctionnalités de Recherche & Logements
1. **Moteur de Recherche Avancé** :
   - Recherche par destination (ville/région).
   - Filtres par type de logement (Villa, Chalet, Riad, etc.).
   - Filtre par plage de prix (Min/Max).
   - Filtre par nombre de voyageurs.
2. **Page Détail Logement** :
   - Galerie de photos haute résolution.
   - Affichage dynamique des **Équipements** avec icônes (Climatisation, Piscine, WiFi, etc.).
   - Localisation et description détaillée.
   - Calendrier de disponibilité interactif (**Flatpickr**).

---

## 💳 Réservation & Paiement
1. **Flux de Réservation** :
   - Sélection des dates avec calcul automatique du prix total.
   - Validation côté client (empêche de réserver sans dates).
   - Création d'une réservation avec statut `En attente`.
2. **Paiement Sécurisé avec Stripe** :
   - Intégration de **Stripe Elements**.
   - Génération d'une intention de paiement sécurisée.
   - Gestion des devises (Conversion TND vers USD/EUR pour compatibilité Stripe).
   - Page de succès après validation du paiement.

---

## 📊 Tableaux de Bord (Dashboards)
### 🧳 Pour le Voyageur
- **Mes Réservations** : Historique et suivi du statut des séjours.
- **Favoris** : Liste des logements sauvegardés.
- **Avis** : Possibilité de laisser des notes et commentaires.

### 🏠 Pour le Propriétaire
- **Gestion des Logements** : Ajouter, modifier ou supprimer des annonces.
- **Suivi des Réservations** : Validation des demandes entrantes.
- **Statistiques de Revenus** : Calcul du chiffre d'affaires net (après commission).

### 🛡️ Pour l'Administrateur
- **Gestion des Utilisateurs** : Liste complète avec possibilité de suppression.
- **Gestion des Commissions** : Configuration du pourcentage prélevé par la plateforme.
- **Modération** : Validation des nouveaux logements publiés.

---

## 🎨 Design & Expérience Utilisateur (UX)
- Interface **Mobile-First** et entièrement responsive.
- Design épuré avec **Glassmorphism** et dégradés modernes.
- Notifications **Toast** (JavaScript) pour confirmer les actions.
- Effets de survol (hover) dynamiques pour une interface vivante.

---
*Généré pour le rapport de projet TunisiaStay — Mai 2026*
