# Guide d'Implémentation : Recherche de Réservations par Période (Admin)

Ce fichier documente les étapes exactes qui ont été réalisées pour ajouter la fonctionnalité de recherche par période (de `date_debut` à `date_fin`) sur la page d'administration des réservations de TunisiaStay (`/admin/reservations`).

## 1. Mise à jour du Repository (`ReservationRepository.php`)

La première étape a consisté à créer une requête personnalisée dans la base de données via Doctrine pour filtrer les réservations par date d'arrivée et/ou de départ.

**Fichier modifié :** `src/Repository/ReservationRepository.php`

**Code ajouté :**
```php
public function findByDateRange(?string $dateDebut, ?string $dateFin): array
{
    $qb = $this->createQueryBuilder('r')
        ->orderBy('r.creeLe', 'DESC');

    if ($dateDebut) {
        // Filtre les réservations qui ont une date d'arrivée supérieure ou égale à la date de début
        $qb->andWhere('r.dateArrivee >= :dateDebut')
           ->setParameter('dateDebut', new \DateTime($dateDebut));
    }

    if ($dateFin) {
        // Filtre les réservations qui ont une date de départ inférieure ou égale à la date de fin
        $qb->andWhere('r.dateDepart <= :dateFin')
           ->setParameter('dateFin', new \DateTime($dateFin));
    }

    return $qb->getQuery()->getResult();
}
```

## 2. Mise à jour du Controller (`AdminController.php`)

La deuxième étape a été de modifier le contrôleur de l'administration pour qu'il puisse lire les dates envoyées depuis l'URL (les paramètres GET de la requête HTTP) et les passer au Repository.

**Fichier modifié :** `src/Controller/Dashboard/AdminController.php`

**Modifications :**
1. Ajout de `Request $request` dans la signature de la méthode.
2. Récupération des paramètres `date_debut` et `date_fin`.
3. Appel de la nouvelle méthode `findByDateRange`.
4. Passage des variables `date_debut` et `date_fin` au template pour pré-remplir le formulaire.

**Code mis à jour :**
```php
#[Route('/admin/reservations', name: 'admin_reservations')]
public function reservations(Request $request, ReservationRepository $repo): Response
{
    // Récupère les paramètres de l'URL ?date_debut=...&date_fin=...
    $dateDebut = $request->query->get('date_debut');
    $dateFin = $request->query->get('date_fin');

    // Récupère les réservations filtrées
    $reservations = $repo->findByDateRange($dateDebut, $dateFin);

    return $this->render('dashboard/admin/reservations.html.twig', [
        'reservations' => $reservations,
        'date_debut'   => $dateDebut,
        'date_fin'     => $dateFin,
    ]);
}
```

## 3. Ajout du formulaire dans le Template (`reservations.html.twig`)

La dernière étape consistait à ajouter une interface utilisateur (un formulaire HTML avec des champs de type `date`) pour permettre à l'administrateur de sélectionner les dates et de soumettre la recherche.

**Fichier modifié :** `templates/dashboard/admin/reservations.html.twig`

**Code ajouté (juste avant le tableau des réservations) :**
```twig
<form method="GET" action="{{ path('admin_reservations') }}" style="display:flex; flex-wrap:wrap; gap:16px; margin-bottom: 24px; align-items: flex-end; background: white; padding: 16px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #F1F5F9">
    
    <div style="display:flex; flex-direction:column; gap:6px;">
        <label for="date_debut" style="font-size:13px; font-weight:600; color:#374151">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" value="{{ date_debut|default('') }}" style="padding:10px 14px; border:1px solid #E2E8F0; border-radius:8px; font-size:14px; color:#1E293B; outline:none;">
    </div>
    
    <div style="display:flex; flex-direction:column; gap:6px;">
        <label for="date_fin" style="font-size:13px; font-weight:600; color:#374151">Date de fin</label>
        <input type="date" id="date_fin" name="date_fin" value="{{ date_fin|default('') }}" style="padding:10px 14px; border:1px solid #E2E8F0; border-radius:8px; font-size:14px; color:#1E293B; outline:none;">
    </div>
    
    <div style="display:flex; gap:10px;">
        <button type="submit" style="padding:10px 20px; background:#2E86AB; color:white; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
            🔍 Filtrer
        </button>
        
        {# Affiche le bouton réinitialiser uniquement si une recherche est en cours #}
        {% if (date_debut is defined and date_debut) or (date_fin is defined and date_fin) %}
            <a href="{{ path('admin_reservations') }}" style="padding:10px 20px; background:#F1F5F9; color:#475569; text-decoration:none; border-radius:8px; font-size:14px; font-weight:600; text-align:center;">
                Réinitialiser
            </a>
        {% endif %}
    </div>
</form>
```

## Résultat 
Désormais, l'administrateur peut se rendre sur `http://127.0.0.1:8000/admin/reservations`, remplir la date de début et/ou la date de fin, et cliquer sur "Filtrer". Seules les réservations correspondant aux critères sélectionnés s'afficheront dans le tableau. Un bouton "Réinitialiser" apparaît également pour effacer les filtres facilement.
