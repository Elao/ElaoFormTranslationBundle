<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Test;

use Elao\Bundle\FormTranslationBundle\Form\Extension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Forms;

abstract class FormTranslationTestCase extends TestCase
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtensions($this->getTypeExtensions())
            ->getFormFactory();
    }

    /**
     * Get Form Type Extensions
     *
     * @return array
     */
    protected function getTypeExtensions()
    {
        $extensions = [
            new Extension\ButtonTypeExtension(),
            new Extension\ChoiceTypeExtension(),
            new Extension\CollectionTypeExtension(),
            new Extension\FormTypeExtension(),
        ];

        return $extensions;
    }
}
