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

    /**
     * @param string $userId
     * @param string $sort
     * @param string $order
     * @param string $entity
     * @param string $groupBy
     * @return int|mixed|string
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getData($userId = '', $sort = '', $order='', $entity='u', $groupBy = '')
    {
        $entityPrefix = 'u.';
        if ($entity && $entity == 'category') {
            $entityPrefix = 'c.';
        }

        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->leftJoin('u.category', 'c');

        if ($userId) {
            $queryBuilder->andWhere('u.id = :userId');
            $queryBuilder->setParameter('userId', $userId);
        }

        if ($sort && $order) {
            $queryBuilder->orderBy($entityPrefix.$sort, $order);
        }

        if ($groupBy) {
            $queryBuilder->groupBy($groupBy);
        }

        if ($userId) {
            return $queryBuilder->getQuery()->getOneOrNullResult();
        } else {
            return $queryBuilder->getQuery()->getResult();
        }

    }
}
