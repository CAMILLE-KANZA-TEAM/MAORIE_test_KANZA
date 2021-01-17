<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getData($userId = '', $filterBy = '', $groupBy = '')
    {

        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->innerJoin('u.category', 'c');

        if ($userId) {
            $queryBuilder->andWhere('u.id = :userId');
            $queryBuilder->setParameter('userId', $userId);
        }


        switch ($filterBy) {

            case 'dateCreation':
                //$queryBuilder
                //->andWhere('p.author = :author')
                //->setParameter('author', $user)
                //->andWhere('p.lastEvents=1')
                //->andWhere('p.isAffected=1')
                ;
                break;

            default:
                break;
        }

        switch ($groupBy) {
            case 'category':
                /*
                $queryBuilder->groupBy('c.id')
                    ->setParameter('author', $user)
                    ->andWhere('p.lastEvents=1')
                    ->andWhere('p.isAffected=1')

                ;
                */
                break;

            default:
                break;
        }

        return $queryBuilder->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $result;

    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
