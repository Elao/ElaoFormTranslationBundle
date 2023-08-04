<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Elao\Bundle\FormTranslationBundle\Builders\FormKeybuilder;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreebuilder;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Tree Aware Extension
 */
abstract class TreeAwareExtension extends AbstractTypeExtension
{
    /**
     * Form Tree treeBuilder
     *
     * @var FormTreebuilder
     */
    protected $treeBuilder;

    /**
     * Form Key treeBuilder
     *
     * @var FormKeybuilder
     */
    protected $keyBuilder;

    /**
     * Buildable keys list
     *
     * @var array
     */
    protected $keys;

    /**
     * Whether automatic generation of missing keys is enabled or not
     *
     * @var bool
     */
    protected $autoGenerate = false;

    /**
     * Default translation domain for all forms
     *
     * @var string|bool|null
     */
    protected $defaultTranslationDomain;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * Enable or disable automatic generation of missing labels
     *
     * @param bool $enabled The Boolean
     */
    public function setAutoGenerate($enabled)
    {
        $this->autoGenerate = $enabled;
    }

    /**
     * Set Tree Builder
     *
     * @param FormTreebuilder $treeBuilder The FormKeyBuilder
     */
    public function setTreebuilder(FormTreebuilder $treeBuilder = null)
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * Set Key Builder
     *
     * @param FormKeybuilder $keyBuilder The FormKeyBuilder
     */
    public function setKeybuilder(FormKeybuilder $keyBuilder = null)
    {
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * Set buildable keys
     *
     * @param array $keys Array of keys
     */
    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * Set default translation domain
     *
     * @param string|bool|null $defaultTranslationDomain
     */
    public function setDefaultTranslationDomain($defaultTranslationDomain)
    {
        $this->defaultTranslationDomain = $defaultTranslationDomain;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->treeBuilder && $this->keyBuilder) {
            foreach ($this->keys as $key => $value) {
                if ($this->optionEquals($options, $key, true)) {
                    $this->generateKey($view, $key, $value);
                }
            }
        }
    }

    /**
     * Generate the key for the given view field
     *
     * @param FormView $view  The form view
     * @param string   $key   a key
     * @param string   $value
     */
    protected function generateKey(FormView &$view, $key, $value)
    {
        if (!isset($view->vars['tree'])) {
            $view->vars['tree'] = $this->treeBuilder->getTree($view);
        }

        $this->setVar($view->vars, $key, $this->keyBuilder->buildKeyFromTree($view->vars['tree'], $value));
    }

    protected function setVar(array &$vars, string $key, $value): void
    {
        if ($this->getPropertyAccessor()->isWritable($vars, $key)) {
            $this->getPropertyAccessor()->setValue($vars, $key, $value);
        } else {
            $vars[$key] = $value;
        }
    }

    protected function optionEquals(array $options, string $key, $value): bool
    {
        if ($this->getPropertyAccessor()->isReadable($options, $key)) {
            return $this->getPropertyAccessor()->getValue($options, $key) === $value;
        }

        return isset($options[$key]) ? $options[$key] === $value : false;
    }

    protected function getPropertyAccessor(): PropertyAccessor
    {
        if (!$this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}
