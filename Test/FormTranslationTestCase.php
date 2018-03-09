<?php

namespace Elao\Bundle\FormTranslationBundle\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Forms;
use Elao\Bundle\FormTranslationBundle\Form\Extension;

abstract class FormTranslationTestCase extends TestCase
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
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
        $extensions = array(
            new Extension\ButtonTypeExtension(),
            new Extension\ChoiceTypeExtension(),
            new Extension\CollectionTypeExtension(),
            new Extension\FormTypeExtension(),
        );

        return $extensions;
    }
}
