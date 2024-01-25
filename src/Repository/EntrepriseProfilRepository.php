<?php

namespace App\Repository;

use App\Entity\EntrepriseProfil;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<EntrepriseProfil>
 *
 * @method EntrepriseProfil|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrepriseProfil|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrepriseProfil[]    findAll()
 * @method EntrepriseProfil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseProfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntrepriseProfil::class);
    }

    //    /**
    //     * @return EntrepriseProfil[] Returns an array of EntrepriseProfil objects
    //     */
    //    public function findByExampleField($value): array
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

    //    public function findOneBySomeField($value): ?EntrepriseProfil
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findPaginationEntreprise(int $page, $limit = 8): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from(EntrepriseProfil::class, 'e')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);

        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result = [
            'data' => $data,
            'pages' => $pages,
            'page' => $page,
            'limit' => $limit
        ];

        return $result;
    }
}
