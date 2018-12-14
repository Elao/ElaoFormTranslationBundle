<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Choice Type Extension
 */
class ChoiceTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [ChoiceType::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return self::getExtendedTypes()[0];
    }
}
