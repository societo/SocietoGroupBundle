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
class AssociationalGroup extends AbstractPageGadget
{
    protected $caption = 'Information of associational-group';

    protected $description = 'A block to show information of the associational-group';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $group = $parentAttributes->get('group');

        return $this->render('SocietoGroupBundle:PageGadget:associational_group.html.twig', array(
            'gadget'  => $gadget,
            'group' => $group,
        ));
    }
}
