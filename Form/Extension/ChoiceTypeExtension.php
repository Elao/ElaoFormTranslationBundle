<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Choice Type Extension
 */
class ChoiceTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'choice';
    }
}
