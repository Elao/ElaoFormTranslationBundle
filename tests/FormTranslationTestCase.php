<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Tests;

use Elao\Bundle\FormTranslationBundle\Form\Extension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\ButtonTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\ChoiceTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\CollectionTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\FormTypeExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormTypeExtensionInterface;

abstract class FormTranslationTestCase extends TestCase
{
    protected FormFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtensions($this->getTypeExtensions())
            ->getFormFactory();
    }

    /**
     * Get Form Type Extensions
     *
     * @return array<FormTypeExtensionInterface<Extension\TreeAwareExtension>>
     */
    protected function getTypeExtensions(): array
    {
        return [
            new ButtonTypeExtension(),
            new ChoiceTypeExtension(),
            new CollectionTypeExtension(),
            new FormTypeExtension(),
        ];
    }
}
