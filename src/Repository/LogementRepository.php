<?php

namespace App\Repository;

use App\Entity\Logement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\SearchFilters;

/**
 * @extends ServiceEntityRepository<Logement>
 */
class LogementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logement::class);
    }

    public function findByFilters(SearchFilters $filters): array
    {
        $qb = $this->createQueryBuilder('l')
            ->where('l.statut = :statut')
            ->setParameter('statut', 'publie');

        if ($filters->ville) {
            $qb->andWhere('l.ville LIKE :ville')
                ->setParameter('ville', '%' . $filters->ville . '%');
        }

        if ($filters->nbVoyageurs > 0) {
            $qb->andWhere('l.maxVoyageurs >= :voyageurs')
                ->setParameter('voyageurs', $filters->nbVoyageurs);
        }

        if ($filters->prixMin) {
            $qb->andWhere('l.prixParNuit >= :prixMin')
                ->setParameter('prixMin', $filters->prixMin);
        }

        if ($filters->prixMax) {
            $qb->andWhere('l.prixParNuit <= :prixMax')
                ->setParameter('prixMax', $filters->prixMax);
        }

        if ($filters->type) {
            $qb->andWhere('l.type = :type')
                ->setParameter('type', $filters->type);
        }

        // Tri
        match ($filters->sortBy) {
            'prix_asc' => $qb->orderBy('l.prixParNuit', 'ASC'),
            'prix_desc' => $qb->orderBy('l.prixParNuit', 'DESC'),
            default => $qb->orderBy('l.creeLe', 'DESC'),
        };

        return $qb->getQuery()->getResult();
    }
    public function recherche(array $criteres): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.media', 'm')
            ->addSelect('m')
            ->where('l.statut = :statut')
            ->setParameter('statut', 'publie');

        if (!empty($criteres['ville'])) {
            $qb->andWhere('l.ville LIKE :ville OR l.region LIKE :ville')
                ->setParameter('ville', '%' . $criteres['ville'] . '%');
        }

        if (!empty($criteres['type'])) {
            $qb->andWhere('l.type = :type')
                ->setParameter('type', $criteres['type']);
        }

        if (!empty($criteres['voyageurs']) && $criteres['voyageurs'] > 0) {
            $qb->andWhere('l.maxVoyageurs >= :voyageurs')
                ->setParameter('voyageurs', $criteres['voyageurs']);
        }

        if (!empty($criteres['prix_min'])) {
            $qb->andWhere('l.prixParNuit >= :prixMin')
                ->setParameter('prixMin', $criteres['prix_min']);
        }

        if (!empty($criteres['prix_max'])) {
            $qb->andWhere('l.prixParNuit <= :prixMax')
                ->setParameter('prixMax', $criteres['prix_max']);
        }

        match ($criteres['tri'] ?? 'recent') {
            'prix_asc' => $qb->orderBy('l.prixParNuit', 'ASC'),
            'prix_desc' => $qb->orderBy('l.prixParNuit', 'DESC'),
            default => $qb->orderBy('l.creeLe', 'DESC'),
        };

        return $qb->getQuery()->getResult();
    }
    //    /**
//     * @return Logement[] Returns an array of Logement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Logement
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
    public function findPopularDestinations(int $limit = 4): array
    {
        return $this->createQueryBuilder('l')
            ->select('l.ville, COUNT(l.id) as logement_count, MAX(m.nomFichier) as image')
            ->leftJoin('l.media', 'm')
            ->where('l.statut = :statut')
            ->setParameter('statut', 'publie')
            ->groupBy('l.ville')
            ->orderBy('logement_count', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
