<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Button Type Extension
 */
class ButtonTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [ButtonType::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return self::getExtendedTypes()[0];
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
}
