<?php

namespace Elao\Bundle\FormTranslationBundle\Tests;

use Symfony\Component\Form\Forms;
use Elao\Bundle\FormTranslationBundle\Form\Extension;

abstract class FormTranslationTestCase extends \PHPUnit_Framework_TestCase
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
