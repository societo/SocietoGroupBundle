<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\PageGadget;

use \Societo\PageBundle\PageGadget\AbstractPageGadget;

/**
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class AssociationalGroupImage extends AbstractPageGadget
{
    const SHOW_WITH_NAME = 'with_name';
    const SHOW_WITH_LINKED_NAME = 'with_linked_name';

    protected $caption = 'Associational Group Image';

    protected $description = 'A block of specified group image';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $group = $parentAttributes->get('group');
        $user = $this->get('security.context')->getToken()->getUser();

        $repository = $this->getDoctrine()->getEntityManager()->getRepository('SocietoGroupBundle:AssociationalGroupMember');
        $isGroupMember = $repository->isGroupMember($group->getId(), $user->getMemberId());

        return $this->render('SocietoGroupBundle:PageGadget:associational_group_image.html.twig', array(
            'gadget'  => $gadget,
            'group' => $group,
            'is_group_member' => $isGroupMember,
        ));
    }
}
