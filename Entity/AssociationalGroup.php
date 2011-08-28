<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Societo\GroupBundle\Repository\AssociationalGroupRepository")
 * @ORM\Table(name="associational_group")
 */
class AssociationalGroup extends AbstractGroup
{
    /**
     * @ORM\ManyToOne(targetEntity="Societo\BaseBundle\Entity\Member")
     * @ORM\JoinColumn(name="creator_member_id", referencedColumnName="id")
     */
    protected $creatorMember;

    /**
     * @ORM\ManyToOne(targetEntity="Societo\Util\StorageBundle\Entity\File")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=true)
     */
    protected $imageFile;

    /**
     * @Assert\File(maxSize = "700k", mimeTypes={"image/gif", "image/jpeg", "image/pjpeg", "image/png"})
     */
    public $file = null;

    public function __construct($name = null, $description = null, $creatorMember = null)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setCreatorMember($creatorMember);
    }

    public function setCreatorMember($creatorMember)
    {
        $this->creatorMember = $creatorMember;
    }

    public function getCreatorMember()
    {
        return $this->creatorMember;
    }

    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
