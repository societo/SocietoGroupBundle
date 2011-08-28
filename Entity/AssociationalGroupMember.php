<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\Entity;

use Societo\BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Societo\GroupBundle\Repository\AssociationalGroupMemberRepository")
 * @ORM\Table(name="associational_group_member")
 */
class AssociationalGroupMember extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Societo\BaseBundle\Entity\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
    protected $member;

    /**
     * @ORM\ManyToOne(targetEntity="AssociationalGroup")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    public function __construct($member, $group)
    {
        $this->member = $member;
        $this->group = $group;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getMember()
    {
        return $this->member;
    }
}
