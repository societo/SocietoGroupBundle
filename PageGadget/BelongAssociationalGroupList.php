<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\PageGadget;

use Societo\PageBundle\PageGadget\AbstractPageGadget;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class BelongAssociationalGroupList extends AbstractPageGadget
{
    protected $caption = 'List of belonging associational-group';

    protected $description = 'A block to display a list of your belonging associational-group';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        $member = $parentAttributes->get('member', $user->getMember());

        $builder = $em->getRepository('SocietoGroupBundle:AssociationalGroupMember')->findByMemberQuery($member->getId());
        $adapter = new DoctrineORMAdapter($builder->getQuery());
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta
            ->setMaxPerPage($gadget->getParameter('max_results', 20))
            ->setCurrentPage($this->get('request')->query->get('page', 1))
        ;

        return $this->render('SocietoGroupBundle:PageGadget:belong_associational_group_list.html.twig', array(
            'gadget'  => $gadget,
            'group_members' => $pagerfanta->getCurrentPageResults(),
            'member' => $member,

            'route_to_more_page' => $gadget->getParameter('route_to_more_page'),
            'has_pager' => $gadget->getParameter('has_pager'),
            'pagerfanta' => $pagerfanta,
            'attributes' => $parentAttributes,
            'show_name' => $gadget->getParameter('show_name'),
        ));
    }

    public function getOptions()
    {
        return array(
            'show_name' => array(
                'type' => 'checkbox',
                'options' => array(
                    'required' => false,
                ),
            ),

            'max_results' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),

            'route_to_more_page' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),

            'has_pager' => array(
                'type' => 'choice',
                'options' => array(
                    'choices' => array(
                        0 => 'No',
                        1 => 'Yes',
                    ),
                ),
            ),
        );
    }
}
