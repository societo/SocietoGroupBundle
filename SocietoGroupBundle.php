<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * SocietoGroupBundle
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class SocietoGroupBundle extends Bundle
{
    public function boot()
    {
        $dispatcher = $this->container->get('event_dispatcher');

        $dispatcher->addListener('onSocietoRoutingParameterBuild', function($event) {
            $event->getManager()
                ->setParameter('group')
            ;
        });

        $dispatcher->addListener('onSocietoMatchedRouteParameterFilter', function ($event) {
            $parameters = $event->getParameters();
            $em = $event->getEntityManager();

            if (isset($parameters['group'])) {
                $parameters['group'] = $em->getRepository('SocietoGroupBundle:AssociationalGroup')->find($parameters['group']);
            }

            $event->setParameters($parameters);
        });

        $dispatcher->addListener('onSocietoGeneratingRouteParameterFilter', function ($event) {
            $parameters = $event->getParameters();
            $em = $event->getEntityManager();

            if (isset($parameters['group'])) {
                $parameters['group'] = $parameters['group']->getId();
            }

            $event->setParameters($parameters);
        });
    }
}
