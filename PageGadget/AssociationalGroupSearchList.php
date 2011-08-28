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
class AssociationalGroupSearchList extends AbstractPageGadget
{
    const NOTHING_FOR_NO_QUERIES = 0;
    const ALL_FOR_NO_QUERIES = 1;

    protected $caption = 'List of searching associational-group result';

    protected $description = 'A block to display a result of searching associational-groups';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $results = array();
        $em = $this->get('doctrine.orm.entity_manager');

        $keyword = '';
        $query = (array)$this->get('request')->query->get('group', $this->get('request')->request->get('group'));  // TODO: Request
        if (isset($query['keyword'])) {
            $keyword = $query['keyword'];
        }

        $builder = null;
        if ('' !== $keyword) {
            $builder = $em->getRepository('SocietoGroupBundle:AssociationalGroup')->findBySearchQuery($keyword);
        } else {
            if (self::ALL_FOR_NO_QUERIES == $gadget->getParameter('result_for_no_queries', self::NOTHING_FOR_NO_QUERIES)) {
                $builder = $em->getRepository('SocietoGroupBundle:AssociationalGroup')->getAllGroupQuery();
            }
        }
        $adapter = new DoctrineORMAdapter($builder->getQuery());
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta
            ->setMaxPerPage($gadget->getParameter('max_results', 20))
            ->setCurrentPage($this->get('request')->query->get('page', 1))
        ;

        return $this->render('SocietoGroupBundle:PageGadget:search_list.html.twig', array(
            'gadget'  => $gadget,
            'results' => $pagerfanta->getCurrentPageResults(),
            'parameters' => $gadget->getParameters(),

            'route_to_more_page' => $gadget->getParameter('route_to_more_page'),
            'has_pager' => $gadget->getParameter('has_pager'),
            'pagerfanta' => $pagerfanta,
            'attributes' => $parentAttributes,
        ));
    }

    public function getOptions()
    {
        return array(
            'result_for_no_queries' => array(
                'type'    => 'choice',
                'options' => array(
                    'choices' => array(
                        self::NOTHING_FOR_NO_QUERIES => 'Nothing results for no queries',
                        self::ALL_FOR_NO_QUERIES     => 'All results for no queries',
                    ),
                    'required' => true,
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
