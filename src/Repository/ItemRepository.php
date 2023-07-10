<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function findBySearchString(string $search, array $sort): array
    {
        $parameters = [
            'search_key' => '%' . $search . '%'
        ];

        $dql = 'SELECT u FROM App\Entity\Item u WHERE (
                    u.code like :search_key OR 
                    u.description like :search_key OR
                    u.bin like :search_key OR
                    u.bar like :search_key
                )';

        $query = $this->getEntityManager()->createQuery($dql)->setMaxResults(50);
        $query->setParameters($parameters);
        return $query->execute();
    }
}
