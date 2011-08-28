<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AssociationalGroupRepository extends EntityRepository
{
    public function findBySearchQuery($keyword)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->select('g')
            ->from('Societo\GroupBundle\Entity\AssociationalGroup', 'g')
            ->where('g.name LIKE :keyword')
            ->orWhere('g.description LIKE :keyword')
            ->setParameter('keyword', '%'.$keyword.'%')
        ;

        return $builder;
    }

    public function getAllGroupQuery()
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->select('g')
            ->from('Societo\GroupBundle\Entity\AssociationalGroup', 'g')
        ;

        return $builder;
    }
}
