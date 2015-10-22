<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Button Type Extension
 */
class ButtonTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'button';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        if ($this->autoGenerate) {
            $resolver->setDefault('label', true);
        }
    }

    /**
     * for Sf < 2.7
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }
}
