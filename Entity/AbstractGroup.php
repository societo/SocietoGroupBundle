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
 * @ORM\MappedSuperclass
 */
abstract class AbstractGroup extends BaseEntity
{
    /**
     * @ORM\Column(name="name", type="text")
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}
