<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form Type Extension
 */
class FormTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
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

        if ($this->defaultTranslationDomain !== null) {
            $resolver->setDefault('translation_domain', $this->defaultTranslationDomain);
        }

        $resolver->setDefault('help', false);
        $resolver->setAllowedTypes('help', ['null', 'string', 'boolean']);
    }
}
