<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * This class provides features to find objects for inputToken.
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class SearchRepository extends EntityRepository
{

    /**
     * Search objects for inputToken
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $query Search query
     *
     * @return array
     */
    public function search($query)
    {
        foreach (array('name', 'title') as $name) {
            if ($this->getClassMetadata()->hasField($name)) {
                $builder = $this->createQueryBuilder('search');

                return $builder->where($builder->expr()->like(sprintf('search.%s', $name), '?1'))
                               ->setParameter(1, "%$query%")
                               ->getQuery()->execute();
            }
        }

        return array();
    }
}
