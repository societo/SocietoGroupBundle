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

class GroupMemberGenerator extends DoctrineEntityGenerator
{
    const ACTIVITY_TYPE_GROUP_MEMBER_JOIN = 'group_join';

    public function getAvailableType()
    {
        return array(
            self::ACTIVITY_TYPE_GROUP_MEMBER_JOIN => 'Member joins to a group',
        );
    }

    protected function getPersistActivity($entity, $em)
    {
        $this->registerActivity($em, $entity->getMember(), 'join', new ActivityObject(), new ActivityObject('"'.$entity->getGroup()->getName().'" group'), '', self::ACTIVITY_TYPE_GROUP_MEMBER_JOIN);
    }

    protected function getUpdateActivity($entity, $em)
    {
        // do nothing
    }
}
