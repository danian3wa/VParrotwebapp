<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Exemplaire;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Exemplaire>
 *
 * @method Exemplaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exemplaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exemplaire[]    findAll()
 * @method Exemplaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExemplaireRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */

    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Exemplaire::class);
        $this->paginator = $paginator;
    }

    public function save(Exemplaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Exemplaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère le prix minimum et maximum correspondant à une recherche
     * @return integer[]
     */
    public function findPrixMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.prix) as prixmin', 'MAX(p.prix) as prixmax')
            ->getQuery()
            ->getScalarResult();
        return [(int)$results[0]['prixmin'], (int)$results[0]['prixmax']];
    }

    /**
     * Récupère le kilometrage minimum et maximum correspondant à une recherche
     * @return integer[]
     */
    public function findKmMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.kilometrage) as kmmin', 'MAX(p.kilometrage) as kmmax')
            ->getQuery()
            ->getScalarResult();
        return [(int)$results[0]['kmmin'], (int)$results[0]['kmmax']];
    }

    /**
     * Récupère le annee minimum et maximum correspondant à une recherche
     * @return integer[]
     */
    public function findAnneeMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.annee) as anneemin', 'MAX(p.annee) as anneemax')
            ->getQuery()
            ->getScalarResult();
        return [(int)$results[0]['anneemin'], (int)$results[0]['anneemax']];
    }

    private function getSearchQuery(SearchData $search, $ignorePrix = false, $ignoreKm = false, $ignoreAnnee = false): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('p');

        if (!empty($search->prixmin) && $ignorePrix === false) {
            $query = $query
                ->andWhere('p.prix >= :prixmin')
                ->setParameter('prixmin', $search->prixmin);
        }

        if (!empty($search->prixmax) && $ignorePrix === false) {
            $query = $query
                ->andWhere('p.prix <= :prixmax')
                ->setParameter('prixmax', $search->prixmax);
        }

        if (!empty($search->kmmin && $ignoreKm === false)) {
            $query = $query
                ->andWhere('p.kilometrage >= :kmmin')
                ->setParameter('kmmin', $search->kmmin);
        }

        if (!empty($search->kmmax) && $ignoreKm === false) {
            $query = $query
                ->andWhere('p.kilometrage <= :kmmax')
                ->setParameter('kmmax', $search->kmmax);
        }

        if (!empty($search->anneemin) && $ignoreAnnee === false) {
            $query = $query
                ->andWhere('p.annee >= :anneemin')
                ->setParameter('anneemin', $search->anneemin);
        }

        if (!empty($search->anneemax) && $ignoreAnnee === false) {
            $query = $query
                ->andWhere('p.annee <= :anneemax')
                ->setParameter('anneemax', $search->anneemax);
        }

        return $query;
    }

    /**
     * Récupère les produits en lien avec une recherce
     * @return PaginationInterface
     */

    public function findSearch(SearchData $search): PaginationInterface
    {   
        

        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );

    }

//    /**
//     * @return Exemplaire[] Returns an array of Examplaire objects
//     */
//    public function findByExempleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Exemplaire
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
