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

class AssociationalGroupMemberRepository extends EntityRepository
{
    public function findByGroupQuery($groupId)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->select('g')
            ->from('Societo\GroupBundle\Entity\AssociationalGroupMember', 'g')
            ->where('g.group = :group')
            ->setParameter('group', $groupId)
        ;

        return $builder;
    }

    public function findByMemberQuery($memberId)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->select('g')
            ->from('Societo\GroupBundle\Entity\AssociationalGroupMember', 'g')
            ->where('g.member = :member')
            ->setParameter('member', $memberId)
        ;

        return $builder;
    }

    public function isGroupMember($groupId, $memberId)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->select('g')
            ->from('Societo\GroupBundle\Entity\AssociationalGroupMember', 'g')
            ->where('g.member = :member')
            ->andWhere('g.group = :group')
            ->setParameter('member', $memberId)
            ->setParameter('group', $groupId)
        ;
        $query = $builder->getQuery();

        try {
            $query->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        } catch (\Doctrine\ORM\NonUniqueResultException $e) {
            return true;
        }

        return true;
    }
}
