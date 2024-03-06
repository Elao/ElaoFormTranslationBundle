<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Choice Type Extension
 */
class ChoiceTypeExtension extends TreeAwareExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [ChoiceType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        if ($this->defaultTranslationDomain !== null) {
            $resolver->setDefault('choice_translation_domain', $this->defaultTranslationDomain);
        }
    }
}
