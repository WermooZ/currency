<?php

namespace NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    /**
     * @param integer $id
     * @param User    $user
     *
     * @return array|null
     */
    public function fetchOneByIdAndUser($id, User $user)
    {
        return $this->createQueryBuilder('n')
            ->where('n.id = :id')
            ->andWhere('IDENTITY(n.author) = :userId')
            ->setParameters([
                'id'     => $id,
                'userId' => $user->getId(),
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    public function fetchIdsByFilters(array $filters)
    {
        $query =  $this->createQueryBuilder('n')
            ->select('n.id');
        
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->andWhere('n.' . $field . ' = :' . $field);
                $query->setParameter($field, $value);
            }
        }

        return $query->getQuery()->getResult();
    }
}
