<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Elao\Bundle\FormTranslationBundle\Builders\FormKeyBuilder;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
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
     */
    protected FormTreeBuilder $treeBuilder;

    /**
     * Form Key treeBuilder
     */
    protected FormKeyBuilder $keyBuilder;

    /**
     * Buildable keys list
     *
     * @var array<string,string>
     */
    protected array $keys;

    /**
     * Whether automatic generation of missing keys is enabled or not
     */
    protected bool $autoGenerate = false;

    /**
     * Default translation domain for all forms
     *
     * @var string|bool|null
     */
    protected $defaultTranslationDomain;

    protected PropertyAccessor $propertyAccessor;

    /**
     * Enable or disable automatic generation of missing labels
     *
     * @param bool $enabled The Boolean
     */
    public function setAutoGenerate(bool $enabled): void
    {
        $this->autoGenerate = $enabled;
    }

    /**
     * Set Tree Builder
     *
     * @param FormTreeBuilder $treeBuilder The FormKeyBuilder
     */
    public function setTreeBuilder(FormTreeBuilder $treeBuilder): void
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * Set Key Builder
     *
     * @param FormKeyBuilder $keyBuilder The FormKeyBuilder
     */
    public function setKeyBuilder(FormKeyBuilder $keyBuilder): void
    {
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * Set buildable keys
     *
     * @param array<string,string> $keys Array of keys
     */
    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }

    /**
     * Set default translation domain
     *
     * @param string|bool|null $defaultTranslationDomain
     */
    public function setDefaultTranslationDomain($defaultTranslationDomain): void
    {
        $this->defaultTranslationDomain = $defaultTranslationDomain;
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if (isset($this->treeBuilder) && isset($this->keyBuilder)) {
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
    protected function generateKey(FormView &$view, $key, $value): void
    {
        if (!isset($view->vars['tree'])) {
            $view->vars['tree'] = $this->treeBuilder->getTree($view);
        }

        $this->setVar($view->vars, $key, $this->keyBuilder->buildKeyFromTree($view->vars['tree'], $value));
    }

    /**
     * @param array<string,mixed> &$vars
     */
    protected function setVar(array &$vars, string $key, mixed $value): void
    {
        if ($this->getPropertyAccessor()->isWritable($vars, $key)) {
            $this->getPropertyAccessor()->setValue($vars, $key, $value);
        } else {
            $vars[$key] = $value;
        }
    }

    /**
     * @param array<string,mixed> $options
     */
    protected function optionEquals(array $options, string $key, mixed $value): bool
    {
        if ($this->getPropertyAccessor()->isReadable($options, $key)) {
            return $this->getPropertyAccessor()->getValue($options, $key) === $value;
        }

        return isset($options[$key]) ? $options[$key] === $value : false;
    }

    protected function getPropertyAccessor(): PropertyAccessor
    {
        if (!isset($this->propertyAccessor)) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}
