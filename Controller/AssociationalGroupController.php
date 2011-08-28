<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Societo\BaseBundle\Util\ArrayAccessibleParameterBag;

class AssociationalGroupController extends Controller
{
    public function createAction($gadget)
    {
        $request = $this->get('request');
        if ($request->getMethod() !== 'POST') {
            throw new \Exception($request->getMethod());
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->get('doctrine.orm.entity_manager');

        $group = new \Societo\GroupBundle\Entity\AssociationalGroup();

        $form = $this->get('form.factory')
            ->create(new \Societo\GroupBundle\Form\AssociationalGroupType(), $group);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $group = $form->getData();
            $group->setCreatorMember($user->getMember());

            if ($group->file) {
                $file = new \Societo\Util\StorageBundle\Entity\File();
                $file->file = $group->file;
                $file->setRandomizedFilename();
                $group->setImageFile($this->get('societo.storage')->storeFromEntity($file));
            }

            $em->persist($group);

            $groupMember = new \Societo\GroupBundle\Entity\AssociationalGroupMember($user->getMember(), $group);
            $em->persist($groupMember);

            $em->flush();

            $this->get('session')->setFlash('success', 'Group was created successfully');

            return $this->redirect($this->generateUrl('group', array('group' => $group)));
        }

        return $this->render('SocietoPluginBundle:Gadget:only_gadget.html.twig', array(
            'gadget' => $gadget,
            'parent_attributes' => $this->get('request')->attributes,
            'parameters' => new ArrayAccessibleParameterBag(array('form' => $form)),
        ));
    }

    public function joinAction($group)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository('SocietoGroupBundle:AssociationalGroupMember');
        if ($repository->isGroupMember($group->getId(), $user->getMemberId())) {
            throw $this->createNotFoundException();
        }

        $groupMember = new \Societo\GroupBundle\Entity\AssociationalGroupMember($user->getMember(), $group);

        $em->persist($groupMember);
        $em->flush();

        $this->get('session')->setFlash('success', 'You\'ve joined this group');

        return new RedirectResponse($this->generateUrl('group', array('group' => $group)));
    }
}
