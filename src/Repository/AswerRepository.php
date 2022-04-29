<?php

namespace App\Repository;

use App\Entity\Aswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aswer[]    findAll()
 * @method Aswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aswer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Aswer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Aswer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getAnswersOnQuestion(int $id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT *, (SELECT username FROM user WHERE user.id = aswer.user_id) as author
            FROM aswer WHERE (aswer.question_id = :id AND aswer.status = TRUE ) ORDER BY aswer.date DESC;
            ';

        $resultSet = $connection->prepare($sql)->executeQuery([
            'id' => $id
        ]);

        return $resultSet->fetchAllAssociative();
    }
    // /**
    //  * @return Aswer[] Returns an array of Aswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aswer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
