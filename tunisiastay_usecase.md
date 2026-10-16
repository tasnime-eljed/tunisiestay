# 📊 Diagramme de Cas d'Utilisation - TunisiaStay

Ce document présente le diagramme de cas d'utilisation professionnel pour la plateforme **TunisiaStay**, modélisé avec PlantUML.

## 🎭 Acteurs du Système
- **Visiteur** : Utilisateur non authentifié qui explore la plateforme.
- **Voyageur** : Utilisateur connecté souhaitant réserver des séjours.
- **Propriétaire** : Utilisateur proposant des hébergements à la location.
- **Administrateur** : Super-utilisateur gérant la plateforme et les configurations.

---

## 📐 Diagramme PlantUML

```plantuml
@startuml TunisiaStay_UseCase
header Plateforme TunisiaStay
footer Projet de Réservation Touristique

left to right direction
skinparam packageStyle rectangle
skinparam roundcorner 10
skinparam shadowing true
skinparam handwritten false

skinparam usecase {
    BackgroundColor White
    BorderColor #2C3E50
    ArrowColor #2C3E50
}

skinparam actor {
    BackgroundColor #EBF5FB
    BorderColor #2C3E50
}

actor "Visiteur" as Guest
actor "Voyageur" as Traveler
actor "Propriétaire" as Owner
actor "Administrateur" as Admin

' Héritage des rôles
Traveler -up-|> Guest
Owner -up-|> Guest

rectangle "Système TunisiaStay" {
    
    package "Authentification & Profil" {
        usecase "S'inscrire" as UC1
        usecase "Se connecter" as UC2
        usecase "Gérer son profil\n(Avatar, Infos, Password)" as UC3
        usecase "Réinitialiser mot de passe" as UC4
    }

    package "Recherche & Consultation" {
        usecase "Rechercher un logement\n(Filtres, Dates, Prix)" as UC5
        usecase "Consulter les détails\nd'une annonce" as UC6
        usecase "Gérer sa liste de favoris" as UC7
    }

    package "Réservations & Expérience" {
        usecase "Effectuer une réservation" as UC8
        usecase "Payer en ligne (Stripe)" as UC9
        usecase "Laisser un avis & note" as UC10
        usecase "Consulter l'historique\ndes réservations" as UC11
    }

    package "Gestion Propriétaire" {
        usecase "Publier / Modifier une annonce" as UC12
        usecase "Gérer les disponibilités\n(Calendrier)" as UC13
        usecase "Valider les réservations" as UC14
        usecase "Consulter ses revenus\n(Stats)" as UC15
    }

    package "Administration Centrale" {
        usecase "Gérer les comptes utilisateurs" as UC16
        usecase "Modérer / Valider les annonces" as UC17
        usecase "Configurer les commissions\nplateforme" as UC18
    }

    ' Relations Visiteur
    Guest --> UC1
    Guest --> UC2
    Guest --> UC4
    Guest --> UC5
    Guest --> UC6

    ' Relations Voyageur
    Traveler --> UC3
    Traveler --> UC7
    Traveler --> UC8
    Traveler --> UC10
    Traveler --> UC11

    ' Relations spécifiques
    UC8 ..> UC9 : <<include>>

    ' Relations Propriétaire
    Owner --> UC3
    Owner --> UC12
    Owner --> UC13
    Owner --> UC14
    Owner --> UC15

    ' Relations Admin
    Admin --> UC3
    Admin --> UC16
    Admin --> UC17
    Admin --> UC18
}

@enduml
```

---

## 📝 Description des Cas d'Utilisation

### 🔐 Authentification & Profil
- **S'inscrire / Se connecter** : Permet l'accès aux fonctionnalités avancées.
- **Gérer son profil** : Chaque utilisateur peut modifier son avatar, ses informations personnelles et son mot de passe.

### 🔍 Recherche & Consultation
- **Recherche multicritères** : Filtrage par destination, type de logement, prix et nombre de voyageurs.
- **Favoris** : Permet aux voyageurs de sauvegarder des annonces pour plus tard.

### 💳 Réservations & Paiements
- **Réservation** : Sélection de dates via un calendrier interactif.
- **Paiement Stripe** : Intégration sécurisée pour la validation financière du séjour.

### 🏠 Gestion Propriétaire
- **Annonces** : Publication de photos, équipements et descriptions.
- **Calendrier** : Gestion dynamique des périodes de disponibilité.

### 🛡️ Administration
- **Modération** : Validation des annonces avant publication pour garantir la qualité.
- **Commissions** : Ajustement global du pourcentage prélevé sur les transactions.
