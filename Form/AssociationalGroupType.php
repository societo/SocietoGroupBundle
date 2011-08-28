<?php

/**
 * SocietoGroupBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\GroupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;

class AssociationalGroupType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', 'text')
            ->add('description')
            ->add('file', 'file', array('required' => false, 'label' => 'Image File'))
            ->add('redirect_to', 'hidden', array('property_path' => false))
        ;
    }

    public function getName()
    {
        return 'group';
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);

        $options['data_class'] = 'Societo\GroupBundle\Entity\AssociationalGroup';

        return $options;
    }
}
