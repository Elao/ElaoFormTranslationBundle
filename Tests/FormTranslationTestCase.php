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
     * @return array<FormTypeExtensionInterface>
     */
    protected function getTypeExtensions(): array
    {
        return [
            new Extension\ButtonTypeExtension(),
            new Extension\ChoiceTypeExtension(),
            new Extension\CollectionTypeExtension(),
            new Extension\FormTypeExtension(),
        ];
    }
}
