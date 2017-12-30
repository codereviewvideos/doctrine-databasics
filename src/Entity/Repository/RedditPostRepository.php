<?php

namespace App\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RedditPostRepository extends EntityRepository
{

    public function someQueryWeCareAbout($id)
    {
        return $this->getEntityManager()->createQuery(
            "
            SELECT p, a
            FROM App\Entity\RedditPost p
            JOIN p.author a
            WHERE p.id > :id
            ORDER BY a.name DESC
            "
        )
                    ->setParameter('id', $id)
                    ->getResult();
    }

}