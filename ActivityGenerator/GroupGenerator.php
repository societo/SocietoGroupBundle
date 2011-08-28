<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\ActivityGenerator;

use Societo\ActivityBundle\ActivityGenerator\DoctrineEntityGenerator;
use Societo\ActivityBundle\ActivityObject;

class GroupGenerator extends DoctrineEntityGenerator
{
    const ACTIVITY_TYPE_GROUP_CREATE = 'group_create';

    public function getAvailableType()
    {
        return array(
            self::ACTIVITY_TYPE_GROUP_CREATE => 'Member creates new associational group',
        );
    }

    protected function getPersistActivity($entity, $em)
    {
        $this->registerActivity($em, $entity->getCreatorMember(), 'create', new ActivityObject('"'.$entity->getName().'" group'), new ActivityObject(), $entity->getDescription(), self::ACTIVITY_TYPE_GROUP_CREATE);
    }

    protected function getUpdateActivity($entity, $em)
    {
        // do nothing
    }
}
