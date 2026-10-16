# 🏗️ Diagramme de Classes - TunisiaStay

Ce document présente le diagramme de classes technique pour la plateforme **TunisiaStay**, modélisé avec PlantUML. Il reflète l'architecture de la base de données et les relations entre les entités Symfony.

---

## 📐 Diagramme PlantUML

```plantuml
@startuml TunisiaStay_ClassDiagram
header Architecture des Entités TunisiaStay
footer Modèle de données Symfony 7

skinparam class {
    BackgroundColor White
    BorderColor #2C3E50
    ArrowColor #2C3E50
    HeaderBackgroundColor #EBF5FB
}

skinparam shadowing true
skinparam roundcorner 10

package "Gestion Utilisateurs" {
    class Utilisateur {
        - int id
        - string email
        - array roles
        - string password
        - string nom
        - string prenom
        - string avatar
        - string telephone
        + getFullName(): string
    }
}

package "Gestion Logements" {
    class Logement {
        - int id
        - string titre
        - string slug
        - text description
        - string type
        - string statut
        - decimal prixParNuit
        - string devise
        - int maxVoyageurs
        - int chambres
        - int sallesDeBain
        - string adresse
        - string ville
        - string region
        - float latitude
        - float longitude
        - DateTime creeLe
    }

    class Media {
        - int id
        - string filename
        - DateTime creeLe
    }

    class Equipement {
        - int id
        - string nom
        - string icone
    }

    class Disponibilite {
        - int id
        - date dateDebut
        - date dateFin
    }
}

package "Réservations & Avis" {
    class Reservation {
        - int id
        - date dateArrivee
        - date dateDepart
        - int nbVoyageurs
        - int nbNuits
        - decimal montantBase
        - decimal tauxCommission
        - decimal montantCommission
        - decimal montantTotal
        - string statut
        - DateTime creeLe
    }

    class Paiement {
        - int id
        - string stripeSessionId
        - string stripePaymentIntentId
        - decimal montant
        - string devise
        - string statut
        - DateTime creeLe
    }

    class Avis {
        - int id
        - text commentaire
        - int note
        - DateTime creeLe
    }

    class Favori {
        - int id
        - DateTime creeLe
    }
}

package "Configuration" {
    class ConfigCommission {
        - int id
        - string nom
        - decimal taux
        - boolean actif
    }
}

' Relations
Utilisateur "1" -- "0..*" Logement : "possède (proprietaire)"
Utilisateur "1" -- "0..*" Reservation : "effectue (voyageur)"
Utilisateur "1" -- "0..*" Avis : "écrit"
Utilisateur "1" -- "0..*" Favori : "sauvegarde"

Logement "1" *-- "0..*" Media : "contient"
Logement "1" -- "0..*" Disponibilite : "a des périodes"
Logement "0..*" -- "0..*" Equipement : "propose"
Logement "1" -- "0..*" Reservation : "reçoit"
Logement "1" -- "0..*" Avis : "est noté par"
Logement "1" -- "0..*" Favori : "est ciblé par"

Reservation "1" -- "1" Paiement : "est réglée par"

@enduml
```

---

## 🔍 Détails des Relations

### 🔗 Utilisateur & Logement
- Un **Utilisateur** (Propriétaire) peut posséder plusieurs **Logements** (1:N).
- Un **Logement** appartient obligatoirement à un seul propriétaire.

### 📅 Réservations
- Une **Reservation** lie un **Voyageur** (Utilisateur) à un **Logement** (1:N dans les deux sens).
- Chaque réservation est associée à un **Paiement** unique (1:1) via l'identifiant Stripe.

### 🏠 Logement & Services
- **Équipements** : Relation ManyToMany (N:M). Un logement peut avoir plusieurs équipements (WiFi, Piscine, etc.) et un équipement peut être présent dans plusieurs logements.
- **Media** : Relation OneToMany (1:N). Un logement peut avoir plusieurs photos.
- **Disponibilité** : Permet de définir des plages de dates spécifiques où le logement est réservable.

### 📊 Configuration
- **ConfigCommission** : Entité isolée gérée par l'administrateur pour définir les taux appliqués lors des calculs de réservation.
