<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Question $entity, bool $flush = true): void
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
    public function remove(Question $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getTopQuestion(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT *, (SELECT COUNT(*) FROM aswer WHERE aswer.question_id = question.id AND aswer.status = TRUE) AS countcom,
       (SELECT username FROM user WHERE user.id = question.user_id) as userName
FROM question WHERE question.status = TRUE ORDER BY countcom DESC LIMIT 1;
            ';

        $result = $connection->prepare($sql)->executeQuery();
        return $result->fetchAllAssociative();
    }
    public function getQuestionWithApproveAnswer(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT *, (SELECT COUNT(*) FROM aswer WHERE aswer.question_id = question.id AND aswer.status = TRUE) AS countcom,
       (SELECT username FROM user WHERE user.id = question.user_id) as userName
FROM question WHERE question.status = TRUE ORDER BY date DESC;
            ';

        $result = $connection->prepare($sql)->executeQuery();
        return $result->fetchAllAssociative();
    }
    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
