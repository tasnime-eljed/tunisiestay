<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    // Avis reçus par un propriétaire
    public function findByProprietaire(Utilisateur $proprietaire): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.logement', 'l')
            ->where('l.proprietaire = :proprietaire')
            ->andWhere('a.estVisible = true')
            ->setParameter('proprietaire', $proprietaire)
            ->orderBy('a.creeLe', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Avis émis par un voyageur
    public function findByVoyageur(Utilisateur $voyageur): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.voyageur = :voyageur')
            ->setParameter('voyageur', $voyageur)
            ->orderBy('a.creeLe', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Note moyenne d'un propriétaire
    public function getNoteMoyenneProprietaire(Utilisateur $proprietaire): float
    {
        $result = $this->createQueryBuilder('a')
            ->select('AVG(a.note) as moyenne')
            ->join('a.logement', 'l')
            ->where('l.proprietaire = :proprietaire')
            ->andWhere('a.estVisible = true')
            ->setParameter('proprietaire', $proprietaire)
            ->getQuery()
            ->getSingleScalarResult();

        return round((float) ($result ?? 0), 1);
    }
}