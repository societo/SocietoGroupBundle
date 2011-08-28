<?php

/**
 * This file is applied CC0 <http://creativecommons.org/publicdomain/zero/1.0/>
 */

namespace Societo\GroupBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Societo\GroupBundle\Entity\AssociationalGroup;
use Societo\GroupBundle\Entity\AssociationalGroupMember;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $admin = $this->getReference('admin');
        $manager->persist($group = new AssociationalGroup('group1', 'group1', $admin));
        $manager->persist(new AssociationalGroupMember($admin, $group));
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
