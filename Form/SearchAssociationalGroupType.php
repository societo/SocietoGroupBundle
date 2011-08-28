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

class SearchAssociationalGroupType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('keyword', 'text', array(
            'required' => false,
        ));
    }

    public function getName()
    {
        return 'group';
    }

    public function getDefaultOptions(array $options)
    {
        $result = parent::getDefaultOptions($options);

        $result['csrf_protection'] = false;

        return $result;
    }
}
