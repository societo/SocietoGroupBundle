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
class CreateAssociationalGroupForm extends AbstractPageGadget
{
    protected $caption = 'Creating form of associational-group';

    protected $description = 'A block to display a form for creating new associational-group';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $group = new \Societo\GroupBundle\Entity\AssociationalGroup();
        if ($parameters->has('form')) {
            $form = $parameters->get('form');
        } else {
            $form = $this->get('form.factory')
                ->create(new \Societo\GroupBundle\Form\AssociationalGroupType(), $group);
            $form['redirect_to']->setData($gadget->getParameter('redirect_to'));
        }

        return $this->render('SocietoGroupBundle:PageGadget:create_associational_group_form.html.twig', array(
            'gadget'  => $gadget,
            'form'    => $form->createView(),
        ));
    }

    public function getOptions()
    {
        return array(
            'redirect_to' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),
        );
    }
}
