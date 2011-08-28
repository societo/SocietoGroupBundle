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
class AssociationalGroupSearchForm extends AbstractPageGadget
{
    protected $caption = 'Search form of associational-form';

    protected $description = 'A block to display a form for searching associational-groups';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $form = $this->get('form.factory')
            ->create(new \Societo\GroupBundle\Form\SearchAssociationalGroupType())
        ;
        $form->bindRequest($this->get('request'));

        return $this->render('SocietoGroupBundle:PageGadget:search_form.html.twig', array(
            'gadget'       => $gadget,
            'form'         => $form->createView(),
            'result_route' => $gadget->getParameter('result_route'),
            'attributes'   => $parentAttributes,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return array(
            'result_route' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),
        );
    }
}
